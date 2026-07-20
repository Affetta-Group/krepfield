<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CModule::IncludeModule("highloadblock");

$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($arParams["TAGS_HIGHLOAD_ID"])->fetch();
$hlentity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
$hldataclass = $hlentity->getDataClass();
foreach ($arResult["ITEMS"] as &$arItem) {
    $hl_db_list = $hldataclass::getList(array(
        'select' => array("UF_NAME"),
        'filter' => array(
            'UF_XML_ID' => $arItem["PROPERTIES"]["TAGS"]["VALUE"]["0"]
        ),
    ));
    if ($hl_db_el = $hl_db_list->Fetch()) {
        $arItem["PROPERTIES"]["TAGS"]["VALUE"]["0"] = $hl_db_el["UF_NAME"];
    }
}
