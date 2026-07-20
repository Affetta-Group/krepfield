<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CModule::IncludeModule('iblock');

foreach ($arResult['SECTIONS'] as &$arSection) {
    $arSection['SVG'] = CFile::GetPath($arSection['UF_PIC_CATALOG_SVG']);
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), array("IBLOCK_ID"=>IntVal($arParams['IBLOCK_ID']),">CATALOG_PRICE_1" => 0 , "ACTIVE"=>"Y", "SECTION_ID" => $arSection["ID"], "INCLUDE_SUBSECTIONS" => 'Y'), Array("ID"));
    if($count = $res->SelectedRowsCount()){
        $arSection["ELEMENT_CNT"] = $count;
    } else {
        $arSection["ELEMENT_CNT"] = 0;
    }
}
