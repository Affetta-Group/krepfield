<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CModule::IncludeModule("iblock");

$db_list = CIBlockSection::GetList(
	array("ID" => "ASC"),
	array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "CODE" => $arResult["VARIABLES"]["SECTION_CODE"]),
	false,
	array("ID", "IBLOCK_ID", "NAME", "DESCRIPTION", "PICTURE", "UF_*")
);
if ($db_el = $db_list->GetNext()) {
	$arResult["SECTION"] = $db_el;
}