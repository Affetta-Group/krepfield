<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/antibot/code/include.php');

use Bitrix\Main\Loader;
use Bitrix\Main;
use Bitrix\Sale;
use \Bitrix\Sale\Order;



setupModules();
setupFavorites();

function IexSendTelegramError($message)
{
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => 'http://paniker.iex.su/telegram_notify.php',
        CURLOPT_POSTFIELDS => [
            'key' => 'RajgGsld2ek%&92',
            'message' => $message
        ]
    ]);
    $result = curl_exec($ch);
    return $result === 'OK';
}

use Bitrix\Main\EventManager;

$PHONE = Ion\Settings::getSpaceField("UF_PHONE", "MAIN");
$PHONE_MSK = Ion\Settings::getSpaceField("UF_PHONE_MSK", "MAIN");
$EMAIL = Ion\Settings::getSpaceField("UF_EMAIL", "MAIN");
$ADDRESS = Ion\Settings::getSpaceField("UF_ADDRESS", "MAIN");
$WORKTIME = Ion\Settings::getSpaceField("UF_WORKTIME", "MAIN");
$COORDS = Ion\Settings::getSpaceField("UF_COORDS", "MAIN");
$LINK_VK = Ion\Settings::getSpaceField("UF_LINK_VK", "MAIN");
$MIN_SUM_ORDER = Ion\Settings::getSpaceField("UF_MIN_SUM_ORDER", "MAIN");
$POLICY = Ion\Settings::getSpaceField("UF_POLICY", "MAIN");
$OFERTA = Ion\Settings::getSpaceField("UF_OFERTA", "MAIN");
$ABOUT = Ion\Settings::getSpaceField("UF_ABOUT", "MAIN");
$SEO_HEAD = Ion\Settings::getSpaceField("UF_SEO_HEAD", "MAIN");
$SEO_BODY = Ion\Settings::getSpaceField("UF_SEO_BODY", "MAIN");
$UR_MOD = Ion\Settings::getSpaceField("UF_UR_MOD", "MAIN");
$WARNING = Ion\Settings::getSpaceField("UF_CONTACTS_WARNING", "MAIN");
$GLOBALS['REQUESITS'] = Ion\Settings::getSpaceField("UF_REQUESITS", "MAIN");


$GLOBALS['telegram_chat_id'] = Ion\Settings::getSpaceField("UF_TELEGRAM_CHAT_ID", "MAIN");
$GLOBALS['telegram_bot_token'] = Ion\Settings::getSpaceField("UF_TELEGRAM_BOT_TOKEN", "MAIN");

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "handlerOnBeforeIBlockElementUpdate");
AddEventHandler("iblock", "OnBeforeIBlockElementAdd", "handlerOnBeforeIBlockElementAdd");
AddEventHandler("main", "OnAfterUserAdd", array("MyClass", "OnAfterUserAdd"));
AddEventHandler("catalog", "OnBeforeProductAdd", "OnBeforeProductAddWeight");
AddEventHandler("catalog", "OnBeforeProductUpdate", "OnBeforeProductUpdateWeight");


class MyClass
{
    function OnAfterUserAdd(&$arFields)
    {
        $user = new CUser;
        $fields["PHONE_NUMBER"] = $arFields["PERSONAL_PHONE"];
        $user->Update($arFields["ID"], $fields);
    }
}


function handlerOnBeforeIBlockElementUpdate(&$arFields)
{
    if ($_REQUEST['mode'] == 'import' && $arFields["IBLOCK_ID"] == "10") {
        if (isset($arFields["PROPERTY_VALUES"][92])) {
            foreach ($arFields["PROPERTY_VALUES"][92] as $arValue) {
                if ($arValue["VALUE"] == "" || $arValue["VALUE"] == "Нет") {
                    $arFields["ACTIVE"] = "N";
                } elseif ($arValue["VALUE"] == "Да") {
                    $arFields["ACTIVE"] = "Y";
                }
            }
        }
    }
}

function handlerOnBeforeIBlockElementAdd(&$arFields)
{
    if ($_REQUEST['mode'] == 'import' && $arFields["IBLOCK_ID"] == "10") {
        if (isset($arFields["PROPERTY_VALUES"][92])) {
            foreach ($arFields["PROPERTY_VALUES"][92] as $arValue) {
                if ($arValue["VALUE"] == "" || $arValue["VALUE"] == "Нет") {
                    $arFields["ACTIVE"] = "N";
                }
            }
        }
    }
}

function setupModules(): void
{
    if (!Bitrix\Main\Loader::includeModule("main")) {
        throw new RuntimeException("Module \"main\" unavailable");
    }

    if (!Bitrix\Main\Loader::includeModule("ion")) {
        throw new RuntimeException("Module \"ion\" unavailable");
    }

    if (!Bitrix\Main\Loader::includeModule("iblock")) {
        throw new RuntimeException("Module \"iblock\" unavailable");
    }
}

function setupFavorites(): void
{
    try {
        $GLOBALS["FAVORITES"] = json_decode($_COOKIE["favorites"], true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        $GLOBALS["FAVORITES"] = array();
    }
}

function getMetaTags()
{
    global $APPLICATION;

    $curPage = $APPLICATION->GetCurDir();

    $dbList = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        array(
            'IBLOCK_TYPE' => 'content',
            'IBLOCK_ID' => '12',
        ),
        false,
        false,
        array('ID', 'IBLOCK_ID', 'PROPERTY_URL', 'PROPERTY_META_TITLE', 'PROPERTY_META_DESCRIPTION', 'PROPERTY_TITLE')
    );
    while ($dbElem = $dbList->GetNext()) {
        if ($curPage === $dbElem['PROPERTY_URL_VALUE']) {
            return array(
                'META_TITLE' => $dbElem['PROPERTY_META_TITLE_VALUE'],
                'META_DESCRIPTION' => $dbElem['PROPERTY_META_DESCRIPTION_VALUE'],
                'TITLE' => $dbElem['PROPERTY_TITLE_VALUE'],
            );
        }
    }

    return false;
}


function OnBeforeProductAddWeight(&$arFields)
{
    if ($_REQUEST['mode'] == 'import')// при импорте из 1С
    {
        //\Bitrix\Main\Diag\Debug::dumpToFile($arFields['WEIGHT']);
        $w = ($arFields['WEIGHT'] / 1000);
        if ($w > 0)
            $arFields['WEIGHT'] = $w;
        return true;
    }
}

function OnBeforeProductUpdateWeight($id, &$arFields)
{
    if ($_REQUEST['mode'] == 'import')// при импорте из 1С
    {
        //\Bitrix\Main\Diag\Debug::dumpToFile($arFields['WEIGHT']);
        $w = ($arFields['WEIGHT'] / 1000);
        if ($w > 0)
            $arFields['WEIGHT'] = $w;
        return true;
    }
}

CModule::AddAutoloadClasses("", array(
    'AffettaCFile' => '/local/php_interface/classes/affetta/AffettaCFile.php',
    'Telegram' => '/local/php_interface/classes/affetta/Telegram.php',
    'Create_bill' => '/local/php_interface/classes/affetta/create_bill.php',
    
));

include_once "debug.php";
include_once "events.php";

//обновление счета
EventManager::getInstance()->addEventHandler('sale', 'OnSaleOrderSaved', function ($event) {
    $order = $event->getParameter('ENTITY');
    Create_bill::create_bill($order->getId());
});



AddEventHandler("main", "OnBeforeEventAdd", "OnBeforeEventAddHandler");
function OnBeforeEventAddHandler(&$event, &$lid, &$arFields)
{
    if ($event == "SALE_NEW_ORDER"){
        $order = \Bitrix\Sale\Order::load($arFields["ORDER_ID"]);
        $paymentIds = $order->getPaymentSystemId();
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/test2.txt", $paymentIds);
        if (in_array(5, $paymentIds)) $arFields["BILL_LINK"] = "<br><a href='https://krepfield.ru/personal/order/bill" . $arFields["ORDER_ID"] . ".pdf'>cсылка на счет<br>";
    }
}

// добавляем/удаляем упаковку при добавлении/удалении товара
Loader::includeModule("sale");

EventManager::getInstance()->addEventHandler(
    "sale",
    "onSaleBasketItemSaved",
    "OnSaleBasketItemSavedHandler"
);

function OnSaleBasketItemSavedHandler(\Bitrix\Main\Event $event)
{
    $basketItem = $event->getParameter("ENTITY");

    if (!$basketItem instanceof \Bitrix\Sale\BasketItem) {
        return;
    }

    $basket = $basketItem->getCollection();
    if (!$basket) {
        return;
    }

    $order = $basket->getOrder();
    if ($order) {
        $orderId = $order->getId();
        if ($orderId !== null && $orderId < 1114) {
            return;
        }
    }

    $packProductId = 316426;
    $uniqueProductIds = [];
    $packItem = null;

    foreach ($basket as $item) {
        $pid = $item->getProductId();
        $quantity = $item->getQuantity();

        if ((int)$pid === $packProductId) {
            $packItem = $item;
            continue;
        }

        if ($quantity > 0) {
            $uniqueProductIds[$pid] = true;
        }
    }

    $uniqueCount = count($uniqueProductIds);
    $existingQuantity = $packItem ? (int)$packItem->getQuantity() : 0;

    if ($uniqueCount === 0 && !$packItem) {
        return;
    }
    if ($uniqueCount === $existingQuantity) {
        return;
    }

    if ($packItem) {
        $packItem->setField("QUANTITY", $uniqueCount);
    } else {
        $newItem = $basket->createItem("catalog", $packProductId);
        $newItem->setFields([
            "QUANTITY" => $uniqueCount,
            "CURRENCY" => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
            "LID" => 's1',
            "SORT" => 1,
            'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
        ]);
    }

    $basket->save();
}



Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleBasketSaved',
    'clearBasket'
);
function clearBasket(Main\Event $event)
{
    $basket = $event->getParameter("ENTITY");
    $basketItems = $basket->getBasketItems();
    if (count($basketItems) === 1) {
    foreach ($basketItems as $item)
    {
        $id = $item->getId();
        $basket->getItemById($id)->delete();
    }
    }
}