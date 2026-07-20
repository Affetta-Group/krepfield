<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CModule::IncludeModule('iblock');

$db_list = CIBlockElement::GetList(
	array("SORT" => "ASC"),
	array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "SECTION_CODE" => $arParams["SECTION_CODE"]),
	false,
	array(),
	array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE")
);
while ($db_el = $db_list->GetNextElement()) {
	$arResult["ITEMS"][] = $db_el->GetFields();
}