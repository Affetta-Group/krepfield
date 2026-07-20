<?php
use Bitrix\Sale;
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;
use \Bitrix\Main\Type\DateTime;
use Bitrix\Highloadblock as HL;

require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";


//$productId = 2891;
//$quantity = 1;
//$customPrice = 111;
//$basePrice = 150;
//$discountPrice = 10;
//
//$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
///** int $productId ID товара */
///** int $quantity количество */
////if ($item = $basket->getExistsItem('catalog', $productId)) {
////    $item->setField('QUANTITY', $item->getQuantity() + $quantity);
////}
////else {
//    $item = $basket->createItem('catalog', $productId);
//    $item->setFields(array(
//        'QUANTITY' => $quantity,
//        'CURRENCY' => Bitrix\Currency\CurrencyManager::getBaseCurrency(),
//        'LID' => Bitrix\Main\Context::getCurrent()->getSite(),
//        'PRICE' => $customPrice,
//        'CUSTOM_PRICE' => 'Y',
//        'NOTES' => 'affettapromo',
//        'BASE_PRICE' => $basePrice,
//        'DISCOUNT_PRICE' => $discountPrice
//   ));
////}
//$basket->save();









if (!CModule::IncludeModule("affettapromo")) return;
if (!CModule::IncludeModule("sale")) return;

class AfPromoItemsPriceRecalculator {
    private $userCash = 0;
    private $maxBonusUseAbility = 0;
    private $useUserCash = 0;
    private $discountProcent = 0;
    private $totalPrice = 0;
    private $onlyshow = false;
    private $ajaxItemsRes = [];
    public function getUserBasket(){
        $arBasketItems = array();

        $dbBasketItems = CSaleBasket::GetList(
            array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL"
            ),
            false,
            false,
            array("ID", "CALLBACK_FUNC", "MODULE",
                "PRODUCT_ID", "QUANTITY", "DELAY",
                "CAN_BUY", "PRICE","BASE_PRICE", "WEIGHT", "NAME", "DETAIL_PAGE_URL", "CURRENCY","MODULE","DISCOUNT_PRICE","DISCOUNT_VALUE","PROPS")
        );
        while ($arItems = $dbBasketItems->Fetch())
        {
            $arBasketItems[] = $arItems;
        }

        return $arBasketItems;
    }
    private function recalculateBasketItem($item) {
        $newPrice = $item['PRICE'] - ( ($item['PRICE'] * $this->discountProcent) / 100 );
        $discount = $item['PRICE'] - $newPrice;

        if($this->action == 'recount') {
            $this->ajaxItemsRes[] = [
                "ID" => $item['ID'],
                "PRODUCT_ID" => $item['PRODUCT_ID'],
                "PRICE" => number_format($newPrice,2,'.',' '),
                "BASE_PRICE" => number_format($item['PRICE'],2,'.',' '),
                "DISCOUNT_PRICE" => $discount,
            ];
        } elseif($this->action == 'fin') {
            \CSaleBasket::Delete($item['ID']);
            $arFields = array(
                "PRODUCT_ID" => $item['PRODUCT_ID'],
                "PRODUCT_PRICE_ID" => 1,
                "PRICE" => $newPrice,
                "CURRENCY" => $item['CURRENCY'],
                "WEIGHT" => $item['WEIGHT'],
                "QUANTITY" => $item['QUANTITY'],
                "LID" => LANG,
                "DELAY" => "N",
                "CAN_BUY" => "Y",
                "NAME" => $item['NAME'],
                "MODULE" => "affettapromo",
                "NOTES" => "",
                "DETAIL_PAGE_URL" => $item['DETAIL_PAGE_URL'],
                "CUSTOM_PRICE" => 'Y',
                "BASE_PRICE" => $item['PRICE'],
                "DISCOUNT_PRICE" => $discount,
            );
            \CSaleBasket::Add($arFields);
        }
    }
    private function setUserCash($cash) {
        global $USER;

        $user = new CUser;
        $fields = Array(
            "UF_PROMO_CASH" => $cash,
        );
        $user->Update($USER->getId(), $fields);
    }
    private function countBasketPrice($arBasketItems) {
        $max = 0;
        foreach ($arBasketItems as $item){
            if($item['MODULE'] == 'affettapromo') continue;
            $max += $item['PRICE'] * $item['QUANTITY'];
        }
        $this->totalPrice = $max;
        return $this->totalPrice;
    }
    private function maxBonusUseAbility($arBasketItems) {
        $max = $this->countBasketPrice($arBasketItems);
        return $max / 2;
    }
    private function calculateDiscountValue() {
//        $this->totalPrice ;
//        $this->maxBonusUseAbility ;
//        $this->useUserCash ;
        return ($this->useUserCash * 100) / $this->totalPrice;
    }
    private function answer($status,$mes,$action = '') {
        $answer = (object)[];
        $answer->status = $status;
        $answer->message = $mes;
        $answer->action = $action;

        $answer->data->items = $this->ajaxItemsRes;

        foreach ($this->ajaxItemsRes as $item){
            $total += $item['PRICE'];
        }
        if(!empty($total)) $answer->data->total = number_format($total,2,'.',' ');

        echo json_encode($answer);
        die;
    }
    private function writeToLog($operation,$value) {
        global $USER;

        Loader::includeModule('highloadblock');

        $hlblock_ID = HL\HighloadBlockTable::getList(array(
            'select' => array('ID'),
            'filter' => array('=NAME' => 'AffettaPromo'),
            'limit' => 1,
        ))->fetch();

        $arHLBlock = HighloadBlockTable::getById($hlblock_ID)->fetch();
        $entity = HighloadBlockTable::compileEntity($arHLBlock);
        $strEntityDataClass = $entity->getDataClass();

        $arData = array(
            'UF_USER_ID' => $USER->getId(),
            'UF_OPERATION_TYPE' => $operation,
            'UF_USER_USED_BONUS' => $value,
            'UF_USER_USED_BONUS_DATE' => new DateTime(),
        );
        $result = $strEntityDataClass::add($arData);
        if ($result->isSuccess()) {
            $intID = $result->getId();
//            echo $intID;
//            die;
        } else {
            echo 'error: ' . $result->getErrorMessages();
            die;
        }
    }
    private function recount($arBasketItems){
        $this->maxBonusUseAbility = $this->maxBonusUseAbility($arBasketItems);

        if ($this->useUserCash > $this->maxBonusUseAbility) $this->useUserCash = $this->maxBonusUseAbility;

        $this->discountProcent = $this->calculateDiscountValue();

        foreach ($arBasketItems as $item) {
            if ($this->userCash <= 0) continue;
            if ($item['CAN_BUY'] != 'Y') continue;
            if ($item['DELAY'] == 'Y') continue;
            if ($item['MODULE'] == 'affettapromo') continue;

            $this->recalculateBasketItem($item);
        }

        if ($this->action == 'fin') $this->setUserCash($this->userCash - $this->useUserCash);
        if ($this->action == 'fin') $this->writeToLog('Списание', $this->useUserCash);

        $this->answer(true, 'all right');
    }
    private function flush($arBasketItems) {
        global $USER;
        CModule::IncludeModule("sale");

        $removed = '';
        $backCount = 0;
        foreach($arBasketItems as $item){
            if($item['MODULE'] == 'affettapromo') {
                $removed .= $item['ID'] . "\n";
                \CSaleBasket::Delete($item['ID']);
                $this->userCash += ($item['BASE_PRICE'] - $item['PRICE']) * $item['QUANTITY'];
                $backCount += ($item['BASE_PRICE'] - $item['PRICE']) * $item['QUANTITY'];

                $arPrice = CCatalogProduct::GetOptimalPrice($item['PRODUCT_ID'], 1, $USER->GetUserGroupArray());

                $arFields = array(
                    "PRODUCT_ID" => $item['PRODUCT_ID'],
                    "PRODUCT_PRICE_ID" => 1,
                    "MODULE" => 'catalog',
                    "PRICE" => $arPrice['PRICE']['PRICE'],
                    "CURRENCY" => $item['CURRENCY'],
                    "WEIGHT" => $item['WEIGHT'],
                    "QUANTITY" => $item['QUANTITY'],
                    "LID" => LANG,
                    "DELAY" => "N",
                    "CAN_BUY" => "Y",
                    "NAME" => $item['NAME'],
                    "DETAIL_PAGE_URL" => $item['DETAIL_PAGE_URL']
                );
                \CSaleBasket::Add($arFields);
            }
        }

        $this->setUserCash($this->userCash);
        if($backCount > 0)$this->writeToLog('Возврат', $backCount);

        $action = '';
        if (!empty($removed)) $action = 'reload';

        $this->answer(true, $removed, $action);

    }
    public function exec($userBonusCash, $action) {
        $userPromo = Bitrix\Affettapromo\Utils::getUserPromoStatus();
        if(!$userPromo) $this->answer(false,'user not promo');
        $this->userCash = $userPromo['UF_PROMO_CASH'];

        $this->action = $action;
        $arBasketItems = $this->getUserBasket();

        if($this->action == 'recount' || $this->action == 'fin') {
            if($this->userCash <= 0) $this->answer(false,'user havent bonuses');
            if($this->userCash < $userBonusCash) $this->answer(false,'use bonuses more then may');
                else $this->useUserCash = $userBonusCash;

            $this->recount($arBasketItems);
        } elseif ($this->action == 'flush') {
            $this->flush($arBasketItems);
        }
    }
}

$app = new AfPromoItemsPriceRecalculator;

$app->exec($_POST['use'],$_POST['action']);
//rdd($app->getUserBasket());