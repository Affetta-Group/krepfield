<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult["ITEMS"] as &$arItem) {
	$arItem["DATE"] = new DateTime($arItem["DISPLAY_ACTIVE_FROM"]);
	$arItem["DATE"] = $arItem["DATE"]->format('d/m/Y');
}