<?php
/* @var array $arParams
 * @var array $arResult
 */

$sections = [];
$current_roots = [];
$new_root = null;


foreach ($arResult['SECTIONS'] as $i => &$arSection){
    $depth_level = (int)($arSection["DEPTH_LEVEL"]);
    if ($depth_level == 1){
        $current_roots = [];
        $sections[] = &$arSection;
    } else {
        $root = &$current_roots[$depth_level - 1];
        $root["CHILDREN"][] = &$arSection;
    }
    $current_roots[$depth_level] = &$arSection;
}
$arResult["SECTIONS_TREE"] = $sections;
