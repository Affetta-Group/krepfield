<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CModule::IncludeModule("highloadblock");
$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($arParams["TAGS_HIGHLOAD_ID"])->fetch();
$hlentity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
$hldataclass = $hlentity->getDataClass();
foreach ($arResult["ITEMS"] as $i => &$arItem) {
    $hl_db_list = $hldataclass::getList(array(
        'select' => array('*'),
        'filter' => array(
        ),
    ));
    while ($hl_db_el = $hl_db_list->Fetch()) {
        if ($arItem["PROPERTIES"]["TAGS"]["VALUE"]["0"] === $hl_db_el["UF_XML_ID"]) {
            $arItem["PROPERTIES"]["TAGS"]["VALUE"]["0"] = $hl_db_el["UF_NAME"];
            $arResult["TAGS"][] = $hl_db_el;
        }
    }
}
