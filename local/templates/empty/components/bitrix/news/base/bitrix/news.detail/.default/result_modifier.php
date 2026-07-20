<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CModule::IncludeModule("highloadblock");

$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($arParams["AUTHOR_HIGHLOAD_ID"])->fetch();
$hlentity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
$hldataclass = $hlentity->getDataClass();
$hl_db_list = $hldataclass::getList(array(
    'select' => array("*"),
    'filter' => array(
        'UF_XML_ID' => $arResult["PROPERTIES"]["AUTHOR"]["VALUE"]
    ),
));
if ($hl_db_el = $hl_db_list->Fetch()) {
    $arResult["AUTHOR"] = $hl_db_el;
}
$cnt = 0;
$db_list = CIBlockElement::GetList(
    array(),
    array('IBLOCK_ID' => $arParams["IBLOCK_ID"], "ACTIVE" => "Y", "PROPERTY_AUTHOR_VALUE" => $arResult["PROPERTIES"]["AUTHOR"]["VALUE"], "!ID" => $arResult["ID"]),
    false,
    array(),
    array('ID', 'DETAIL_PAGE_URL', 'NAME')
);
while ($db_el = $db_list->GetNextElement()) {
    $arResult["AUTHOR"]["ARTICLE"][] = $db_el->GetFields();
    $cnt++;
}
$arResult["AUTHOR"]["COUNT_ARTICLE"] = $cnt+1;

$hlblock2 = Bitrix\Highloadblock\HighloadBlockTable::getById($arParams["TAGS_HIGHLOAD_ID"])->fetch();
$hlentity2 = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock2);
$hldataclass2 = $hlentity2->getDataClass();

$hl_db_list2 = $hldataclass2::getList(array(
    'select' => array("*"),
    'filter' => array("UF_XML_ID" => $arResult["PROPERTIES"]["TAGS"]["VALUE"]),
));
while ($hl_db_el2 = $hl_db_list2->Fetch()) {
    $arResult["TAGS"][] = $hl_db_el2;
}