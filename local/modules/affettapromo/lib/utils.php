<?php

namespace Bitrix\Affettapromo;

use COption;
use \CUser;
use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable;
use \Bitrix\Main\Type\DateTime;
use Bitrix\Highloadblock as HL;

class Utils {
    static function getUserPromoStatus() {
        global $USER;
        global $APPLICATION;



        $clearBonuses = true;
        if (\CModule::IncludeModule('sale')) {
            $arFilter = array(
                "USER_ID" => $USER->GetID(),
                ">=DATE_INSERT" => date('d.m.Y', strtotime("-6 months"))
            );
            $dbSales = \CSaleOrder::GetList(array("DATE_INSERT" => "DESC"), $arFilter);

            if ($arSale = $dbSales->GetNext()) {
                $clearBonuses = false;
            }
        }
        if($clearBonuses) {
            $user = new \CUser;
            $fields = Array(
                "UF_PROMO_CASH"  => 0,
            );
            $user->Update($USER->GetID(), $fields);
        }



        $arResult = [];

        if(COption::GetOptionString("affettapromo", "MODULE_ACTIVE", false) != 'Y') return false;

        $user_uf_fields = ['UF_POSITION','UF_PROMO_CASH','UF_PROMO_EXEC','UF_PROMO_TYPE','UF_CUSTOM_PROMO_PROC'];
        $user_promo_types = [
            'ur' => [
                'NAME' => 'Юридическое лицо',
                'MULTI' => COption::GetOptionString("affettapromo", "REWARD_SIZE_UR", "20"),
            ],
            'fz' => [
                'NAME' => 'Физическое лицо',
                'MULTI' => COption::GetOptionString("affettapromo", "REWARD_SIZE_FZ", "5"),
            ]
        ];

        $user = CUser::GetByID($USER->GetID())->Fetch();

        if(!$user['UF_PROMO_BLOCK']) return false;

        foreach ($user_uf_fields as $item){
            $res[$item] = $user[$item];
        }

        if(empty($user['UF_CUSTOM_PROMO_PROC']) && !empty($res['UF_PROMO_TYPE'])) {
            $obEnum = new \CUserFieldEnum;
            $rsEnum = $obEnum->GetList(array(), array("USER_FIELD_ID" => 73, "ID" => $res['UF_PROMO_TYPE']));
            if ($arEnum = $rsEnum->GetNext()) {
                $res['UF_PROMO_TYPE'] = $user_promo_types[$arEnum['XML_ID']]['NAME'];
                $res['UF_PROMO_MULTI'] = $user_promo_types[$arEnum['XML_ID']]['MULTI'];
            }
        } elseif(!empty($user['UF_CUSTOM_PROMO_PROC'])) {
            $res['UF_PROMO_TYPE'] = 'Кастомный';
            $res['UF_PROMO_MULTI'] = $user['UF_CUSTOM_PROMO_PROC'];
        }

        if(empty($res['UF_PROMO_CASH'])) $res['UF_PROMO_CASH'] = 0;

        return $res;
    }
    static function OnStatusUpdateHandler($id, $val) {
        if(COption::GetOptionString("affettapromo", "MODULE_ACTIVE", false) != 'Y') return false;

//        define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");

        if($val !== 'Y') return;
        $order = \Bitrix\Sale\Order::load($id);

//        AddMessage2Log(print_r($order->getUserId(),true), "affettapromo");
//        AddMessage2Log(print_r($order->getPrice(),true), "affettapromo");

        $user_promo_types = [
            'ur' => [
                'NAME' => 'Юридическое лицо',
                'MULTI' => COption::GetOptionString("affettapromo", "REWARD_SIZE_UR", "20"),
            ],
            'fz' => [
                'NAME' => 'Физическое лицо',
                'MULTI' => COption::GetOptionString("affettapromo", "REWARD_SIZE_FZ", "5"),
            ]
        ];

        $sum = $order->getPrice();
        $user_id = $order->getUserId();
        $user = \CUser::GetByID($user_id)->Fetch();

        if(!$user['UF_PROMO_BLOCK'] || (empty($user['UF_PROMO_TYPE']) && empty($user['UF_CUSTOM_PROMO_PROC']))) return false;

        if(empty($user['UF_CUSTOM_PROMO_PROC']) && !empty($user['UF_PROMO_TYPE'])) {
            $obEnum = new \CUserFieldEnum;
            $rsEnum = $obEnum->GetList(array(), array("USER_FIELD_ID" => 73, "ID" => $user['UF_PROMO_TYPE']));
            if ($arEnum = $rsEnum->GetNext()) {
                $multiplier = $user_promo_types[$arEnum['XML_ID']]['MULTI'];
            }
        } elseif(!empty($user['UF_CUSTOM_PROMO_PROC'])) {
            $multiplier = $user['UF_CUSTOM_PROMO_PROC'];
        } else {
            return false;
        }

        $bonus = $sum * ($multiplier / 100);

        if(empty($user['UF_PROMO_CASH'])) $user['UF_PROMO_CASH'] = 0;
        $newBonus = $user['UF_PROMO_CASH'] + $bonus;

        $user = new \CUser;
        $fields = Array(
            "UF_PROMO_CASH"  => ceil($newBonus),
        );
        $user->Update($user_id, $fields);

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
            'UF_USER_ID' => $user_id,
            'UF_OPERATION_TYPE' => 'Пополнение',
            'UF_USER_USED_BONUS' => $bonus,
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
}