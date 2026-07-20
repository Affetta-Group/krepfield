<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CModule::IncludeModule("highloadblock");

$activeTags = [];
$dbItemsList = CIBlockElement::GetList(
    array('SORT' => 'ASC'),
    array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y')
);
while ($ob = $dbItemsList->GetNextElement()) {
    $tags = $ob->GetProperties(
        [],
        ['CODE' => 'TAGS', 'EMPTY' => 'N']
    )['TAGS'];
    foreach ($tags['VALUE'] as $val) {
        $activeTags[] = $val;
    }
}

$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($arParams["QUERY_HIGHLOAD_ID"])->fetch();
$hlentity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
$hldataclass = $hlentity->getDataClass();

$hl_db_list = $hldataclass::getList(array(
    'select' => array("UF_QUERY"),
    'filter' => array(),
));
while ($hl_db_el = $hl_db_list->Fetch()) {
    $arResult["QUERY"][] = $hl_db_el["UF_QUERY"];
}

$hlblock2 = Bitrix\Highloadblock\HighloadBlockTable::getById($arParams["TAGS_HIGHLOAD_ID"])->fetch();
$hlentity2 = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock2);
$hldataclass2 = $hlentity2->getDataClass();

$hl_db_list2 = $hldataclass2::getList(array(
    'select' => array("*"),
    'filter' => array(),
));
while ($hl_db_el2 = $hl_db_list2->Fetch()) {
    if (in_array($hl_db_el2['UF_XML_ID'], $activeTags)) {
        $arResult["TAGS"][] = $hl_db_el2;
    }
}
