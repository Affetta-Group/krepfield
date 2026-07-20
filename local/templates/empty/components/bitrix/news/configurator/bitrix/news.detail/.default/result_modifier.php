<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}
$arResult['SUB_QUESTIONS'] = [];

$arArrays = array_filter($arResult['PROPERTIES'], function($k) {
    return str_contains($k, 'RRULE');
}, ARRAY_FILTER_USE_KEY);


foreach ($arArrays as $PROPERTY) {
    if (is_array($PROPERTY['VALUE']) && !empty($PROPERTY['VALUE'])) {
        $arResult['SUB_QUESTIONS'] = array_unique(array_merge($arResult['SUB_QUESTIONS'], $PROPERTY['VALUE']));
    }
}

if (!$USER->IsAdmin() && $arResult['PROPERTIES']['ONLY_ADMINS']['VALUE'] == 'Да')
    header('Location: /configurator/');