<?php

namespace Krepfield;

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;

/** Switches only automatic exports. No changes to the vendor module or its options. */
final class BoxberryExport
{
    private static $enabled = false;
    private static $pending = [];
    private static $busy = [];
    private static $registered = false;

    public static function register(): void
    {
        if (self::$registered || !Loader::includeModule('up.boxberrydelivery')) {
            return;
        }
        $manager = EventManager::getInstance();
        $handlers = $manager->findEventHandlers('sale', 'OnOrderSave');
        $matches = [];
        foreach ($handlers as $key => $handler) {
            $callback = $handler['CALLBACK'] ?? null;
            if (is_array($callback)
                && strcasecmp((string)$callback[0], 'CDeliveryBoxberry') === 0
                && strcasecmp((string)$callback[1], 'orderCreate') === 0) {
                $matches[$key] = $handler;
            }
        }
        // Never enable the new exporter unless the installed legacy callback is identified.
        if (count($matches) !== 1) {
            error_log('Krepfield Boxberry: unexpected OnOrderSave handlers; switch not installed');
            return;
        }
        self::$enabled = (require dirname(__DIR__) . '/boxberry-export-config.php') === true;
        foreach ($matches as $key => $handler) {
            $manager->removeEventHandler('sale', 'OnOrderSave', $key);
            $manager->addEventHandlerCompatible(
                'sale', 'OnOrderSave', [self::class, 'onLegacySave'], false, $handler['SORT']
            );
        }
        $manager->addEventHandler('sale', 'OnSaleOrderSaved', [self::class, 'onSaved']);
        self::$registered = true;
        // Run after the payment callback has finished its saves/transactions, not on early PD.
        register_shutdown_function([self::class, 'flush']);
    }

    public static function onLegacySave($id, $fields)
    {
        $id = (int)$id;
        if ($id <= 0 || !self::isBoxberry((int)($fields['DELIVERY_ID'] ?? 0))) {
            return \CDeliveryBoxberry::orderCreate($id, $fields);
        }
        return self::locked($id, static function () use ($id, $fields) {
            // Preserve the vendor's NEW/PVZ record in the new route as well as on rollback.
            if (self::$enabled || self::readState($id) !== null) {
                self::ensureRecord($id, $fields);
                return true;
            }
            return \CDeliveryBoxberry::orderCreate($id, $fields);
        });
    }

    public static function onSaved($event): void
    {
        if (self::$enabled) {
            $order = $event->getParameter('ENTITY');
            if ($order && (int)$order->getId() > 0) {
                self::$pending[(int)$order->getId()] = true;
            }
        }
    }

    public static function flush(): void
    {
        if (!self::$enabled || !self::$pending) {
            return;
        }
        $lastError = error_get_last();
        if ($lastError && in_array($lastError['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
            return;
        }
        $ids = array_keys(self::$pending);
        self::$pending = [];
        foreach ($ids as $id) {
            self::locked($id, static function () use ($id) {
                self::export($id);
            });
        }
    }

    private static function export(int $id): void
    {
        // A separate nonpersistent connection can only see committed payment data.
        // Never commit or otherwise interfere with the payment handler's transaction.
        $primary = Application::getConnection();
        $configuration = $primary->getConfiguration();
        $configuration['options'] = (int)($configuration['options'] ?? 2) & ~1;
        $class = get_class($primary);
        $connection = new $class($configuration);
        try {
            $order = $connection->query('SELECT ID, LID, DELIVERY_ID, PAYED, CANCELED, PRICE, CURRENCY'
                . ' FROM b_sale_order WHERE ID=' . $id)->fetch();
            $payment = $connection->query('SELECT COALESCE(SUM(`SUM`), 0) AS TOTAL FROM b_sale_order_payment'
                . " WHERE ORDER_ID=" . $id . " AND PAID='Y' AND CURRENCY='"
                . $connection->getSqlHelper()->forSql((string)($order['CURRENCY'] ?? '')) . "'")->fetch();
            $shipment = $connection->query('SELECT ID FROM b_sale_order_delivery WHERE ORDER_ID=' . $id
                . " AND `SYSTEM`='N' AND TRACKING_NUMBER IS NOT NULL AND TRACKING_NUMBER<>'' LIMIT 1")->fetch();
        } finally {
            $connection->disconnect();
        }
        if (!$order || $order['PAYED'] !== 'Y' || $order['CANCELED'] === 'Y'
            || !self::isBoxberry((int)$order['DELIVERY_ID'])) {
            return;
        }
        if (round((float)$payment['TOTAL'], 2) < round((float)$order['PRICE'], 2)) {
            return;
        }
        $record = \CBoxberryOrder::GetByOrderId($id);
        if (!empty($record['TRACKING_CODE']) || $shipment) {
            return;
        }
        if (self::readState($id) !== null) {
            self::log($id, 'blocked_previous_attempt');
            return;
        }
        // The vendor's profile option is broken for numeric delivery IDs. Do not send COD.
        if (Option::get('up.boxberrydelivery', 'BB_PAYMENT_AS_PROFILE_TYPE') === 'Y') {
            self::log($id, 'blocked_payment_profile_option');
            return;
        }
        self::ensureRecord($id, $order);
        // CSaleOrder::GetByID caches earlier PD saves in this per-request global.
        // Invalidate this order only, after committed payment has been independently checked.
        unset($GLOBALS['SALE_ORDER']['SALE_ORDER_CACHE_' . $id]);
        // The vendor rereads through the legacy API: verify that exact snapshot too.
        $vendorOrder = \CBoxberry::GetFullOrderData($id);
        if (!$vendorOrder || $vendorOrder['PAYED'] !== 'Y'
            || (float)\CBoxberry::getPaymentSum(
                $vendorOrder['PRICE'], $vendorOrder['PAYED'], $vendorOrder['DELIVERY_ID']
            ) !== 0.0) {
            self::log($id, 'blocked_vendor_payment_snapshot');
            return;
        }
        // Persist BEFORE the network call. Survives PHP death, lost replies and flag rollback.
        self::writeState($id, ['status' => 'in_flight', 'time' => date(DATE_ATOM)]);
        try {
            $result = (new \CBoxberryParsel())->parselCreate($id);
            $record = \CBoxberryOrder::GetByOrderId($id);
            $track = (string)($result['track'] ?? $record['TRACKING_CODE'] ?? '');
            $status = $track !== '' ? 'created' : 'needs_review';
            self::writeState($id, ['status' => $status, 'time' => date(DATE_ATOM), 'track' => $track]);
            self::log($id, $status);
        } catch (\Throwable $e) {
            // Do not log provider response bodies, customer data or credentials.
            self::writeState($id, ['status' => 'needs_review', 'time' => date(DATE_ATOM)]);
            self::log($id, 'needs_review_exception');
        }
    }

    private static function isBoxberry(int $deliveryId): bool
    {
        $all = \Bitrix\Sale\Delivery\Services\Manager::getActiveList();
        foreach ($all as $parent) {
            if ($parent['CODE'] === 'boxberry') {
                foreach ($all as $profile) {
                    if ((int)$profile['ID'] === $deliveryId
                        && (int)$profile['PARENT_ID'] === (int)$parent['ID']) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private static function ensureRecord(int $id, array $order): void
    {
        if (!\CBoxberryOrder::GetByOrderId($id)) {
            $result = \CBoxberryOrder::Add([
                'ORDER_ID' => $id, 'DATE_CHANGE' => date('d.m.Y H:i:s'),
                'LID' => $order['LID'], 'PVZ_CODE' => (string)($_SESSION['selPVZ'] ?? ''),
                'STATUS' => '0', 'STATUS_TEXT' => 'NEW', 'STATUS_DATE' => date('d.m.Y H:i:s'),
            ]);
            if (!$result) {
                throw new \RuntimeException('Boxberry order record could not be initialized');
            }
        }
    }

    private static function directory(): string
    {
        // Sibling of document root, never HTTP-accessible via either site's root.
        $directory = dirname(rtrim($_SERVER['DOCUMENT_ROOT'], '/')) . '/.krepfield-boxberry-export';
        if (!is_dir($directory) && !@mkdir($directory, 0700, true) && !is_dir($directory)) {
            throw new \RuntimeException('Private Boxberry state directory is unavailable');
        }
        return $directory;
    }

    private static function readState(int $id): ?array
    {
        $path = self::directory() . '/' . $id . '.json';
        if (!file_exists($path)) {
            return null;
        }
        $value = json_decode((string)file_get_contents($path), true);
        if (!is_array($value) || empty($value['status'])) {
            throw new \RuntimeException('Invalid Boxberry attempt state');
        }
        return $value;
    }

    private static function writeState(int $id, array $state): void
    {
        $path = self::directory() . '/' . $id . '.json';
        $temporary = $path . '.tmp';
        $json = json_encode($state, JSON_THROW_ON_ERROR);
        if (file_put_contents($temporary, $json) !== strlen($json)) {
            throw new \RuntimeException('Boxberry attempt state could not be written');
        }
        chmod($temporary, 0600);
        if (!rename($temporary, $path)) {
            throw new \RuntimeException('Boxberry attempt state could not be committed');
        }
    }

    private static function locked(int $id, callable $callback)
    {
        if (isset(self::$busy[$id])) {
            return true;
        }
        $handle = null;
        try {
            $handle = fopen(self::directory() . '/' . $id . '.lock', 'c');
            if (!$handle || !flock($handle, LOCK_EX | LOCK_NB)) {
                self::log($id, 'concurrent_call_skipped');
                return true;
            }
            chmod(self::directory() . '/' . $id . '.lock', 0600);
            self::$busy[$id] = true;
            return $callback();
        } catch (\Throwable $e) {
            error_log('Krepfield Boxberry order ' . $id . ': automatic export blocked by internal error');
            return true;
        } finally {
            unset(self::$busy[$id]);
            if (is_resource($handle)) {
                flock($handle, LOCK_UN);
                fclose($handle);
            }
        }
    }

    private static function log(int $id, string $status): void
    {
        $line = json_encode(['time' => date(DATE_ATOM), 'order_id' => $id, 'status' => $status]) . "\n";
        if (@file_put_contents(self::directory() . '/events.jsonl', $line, FILE_APPEND | LOCK_EX) === false) {
            error_log('Krepfield Boxberry order ' . $id . ': ' . $status);
        }
    }
}
