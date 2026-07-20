<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$count_childs = 0;

foreach ($arResult['SECTIONS'] as $i => $SECTION) {
	if ($SECTION["DEPTH_LEVEL"] === "3") {
		$arResult['SECTIONS_TREE'][$i] = $SECTION;
		$j = $i;
	} elseif ($SECTION["DEPTH_LEVEL"] === "4") {
		$arResult['SECTIONS_TREE'][$j]["CHILDS"][$i] = $SECTION;
		$count_childs++;
		$arResult['SECTIONS_TREE'][$j]["CHILDS"]["COUNT_CHILDS"] = $count_childs;
	}
}