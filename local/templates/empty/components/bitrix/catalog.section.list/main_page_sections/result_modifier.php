<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CModule::IncludeModule('iblock');

$db_list = CIBlockElement::GetList(
	array("RAND" => "ASC"),
	array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "SECTION_CODE" => $arParams["SECTION_CODE"] ),
	false,
	array(),
	array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE")
);
while ($db_el = $db_list->GetNextElement()) {
	$arResult["ITEMS"][] = $db_el->GetFields();
}
switch ($arResult["SECTION"]["UF_COLOR"]){
    case 5: $arResult["SECTION"]["UF_COLOR"] = 'bg1'; break;
    case 6: $arResult["SECTION"]["UF_COLOR"] = 'bg2'; break;
    case 7: $arResult["SECTION"]["UF_COLOR"] = 'bg3'; break;
}