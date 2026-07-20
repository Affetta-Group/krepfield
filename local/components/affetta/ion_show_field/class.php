<?php
use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

class ionShowField extends CBitrixComponent
{
    public function executeComponent()
    {
        if(!Loader::includeModule("highloadblock")) return;

        $hlbl = $this->arParams['HBLOCK_ID'];
        $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $rsData = $entity_data_class::getList(array(
            "select" => ["UF_VAR_VALUE", "UF_VAR_NAME"],
            "order" => array("ID" => "ASC"),
            "filter" => array("UF_VAR_NAME" => $this->arParams['FIELDS'])
        ));

        while($arData = $rsData->Fetch()){
            if(!in_array($arData['UF_VAR_NAME'], $this->arParams['FIELDS'])) continue;

            if(!isset($GLOBALS['ion'][$arData['UF_VAR_NAME']])) {
                $GLOBALS['ion'][$arData['UF_VAR_NAME']] = $arData['UF_VAR_VALUE'];
            }
        }

        $this->includeComponentTemplate();
    }
}