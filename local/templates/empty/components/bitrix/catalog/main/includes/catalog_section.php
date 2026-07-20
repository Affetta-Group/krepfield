<?php
$base_price = CCatalogGroup::GetBaseGroup();
$filterName = 'arMyNewFilter';
$GLOBALS[$filterName] = ['>CATALOG_PRICE_1' => 0];
if (!empty($arParams['FILTER_NAME']) && !empty($GLOBALS[$arParams['FILTER_NAME']]) && is_array($GLOBALS[$arParams['FILTER_NAME']])) {
    $GLOBALS[$filterName] = array_merge_recursive($GLOBALS[$arParams['FILTER_NAME']], $GLOBALS[$filterName]);
}

$start = microtime(true);

require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/php/elastic/functions.php';
$osConfig = require $_SERVER['DOCUMENT_ROOT'] . '/tools/php/elastic/config.php';
$os = openSearchConnect($osConfig, [CURLOPT_TIMEOUT=>10]);

$perPage = (int)trim(!empty($_COOKIE["countProducts"]) ? trim($_COOKIE["countProducts"]) : $arParams["PAGE_ELEMENT_COUNT"]);
if ($perPage < 1) {
    $perPage = 20;
}

$page = (int)($_GET[$arParams['PAGINATOR_ID']] ?? 1);

$from = $perPage * ($page - 1);
$osRequest = [
    'index' => $osConfig['INDEX'],
    'body' => [
        'query' => [],
    ],
    'track_total_hits' => true
];
$filter = $GLOBALS[$filterName];
if (isset($filter['FACET_OPTIONS'])) {
    unset($filter['FACET_OPTIONS']);
}

$osRequest = array_merge_recursive($osRequest, convertBitrixFilterToOs($filter, $arParams['IBLOCK_ID']));

$osRequest['from'] = $from;
$osRequest['size'] = $perPage;

//SORT

$sortReplaces = [
    'id' => '_id',
    'ID' => '_id',
    'show_counter' => 'show_counter',
    'catalog_price_' . $base_price['ID'] => 'price'
];
$osRequest['body']['sort'] = [];
if (isset($sortReplaces[$sort["ELEMENT_SORT_FIELD"]])) {
    $osRequest['body']['sort'][$sortReplaces[$sort["ELEMENT_SORT_FIELD"]]] = $sort["ELEMENT_SORT_ORDER"];
}
if (isset($sortReplaces[$arParams["ELEMENT_SORT_FIELD2"]])) {
    $osRequest['body']['sort'][$sortReplaces[$arParams["ELEMENT_SORT_FIELD2"]]] = $arParams["ELEMENT_SORT_ORDER2"];
}

//Filter Section
if (!empty($arResult['SECTION']['ID'])) {
    $osRequest['body']['query']['bool']['must'][]['term']['sections'] = $arResult['SECTION']['ID'];
}

$paginator = '';
try {
    $data = $os->search($osRequest);
    $total = $data['hits']['total']['value'];

    $nav = new \Bitrix\Main\UI\PageNavigation($arParams['PAGINATOR_ID']);
    $nav->allowAllRecords(false)
        ->setCurrentPage($page)
        ->setPageSize($perPage);
    $nav->setRecordCount($total);

// bug
//    $GLOBALS[$filterName]['ID'] = [0];
//    foreach ($data['hits']['hits'] as $hit) {
//        $GLOBALS[$filterName]['ID'][] = (int)$hit['_id'];
//    }
// bug

    ob_start();
    $APPLICATION->IncludeComponent(
        "bitrix:main.pagenavigation", $arParams['PAGER_TEMPLATE'],
        array(
            "NAV_OBJECT" => $nav,
            "SEF_MODE" => "N",
        ),
        $component
    );
    $paginator = ob_get_clean();
} catch (\OpenSearch\Common\Exceptions\NoNodesAvailableException $e) {
    IexSendTelegramError('krepfield.ru: NoNodesAvailableException in section.php: '.$e->GetMessage());
    IexSendTelegramError('krepfield.ru: OpenSearch request: '.json_encode($osRequest));
} catch (Exception $e) {
    IexSendTelegramError('krepfield.ru: OpenSearchError in section.php: '.$e->GetMessage());
    IexSendTelegramError('krepfield.ru: OpenSearch request: '.json_encode($osRequest));
}

//!empty($_COOKIE["countProducts"]) ? $_COOKIE["countProducts"] : $arParams["PAGE_ELEMENT_COUNT"]
//var_dump(microtime(true)-$start);

//unset($filter[">CATALOG_PRICE_1"]);
//unset($filter["=PROPERTY_65"]);
//unset($filter["PROPERTY_KF_DLYA_SAYTA_AKTUALNOST"]);
//unset($GLOBALS["arMyNewFilter"]["ID"]);


$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "catalog",
    array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "TEMP_ITEM" => $tempItem,
        "ELEMENT_SORT_FIELD" => $sort["ELEMENT_SORT_FIELD"],
        "ELEMENT_SORT_ORDER" => $sort["ELEMENT_SORT_ORDER"],
        "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
        "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
        "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
        "HIDE_SECTION_DESCRIPTION" => $arParams["HIDE_SECTION_DESCRIPTION"],
        "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
        "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
        "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
        "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
        "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
        "BASKET_URL" => $arParams["BASKET_URL"],
        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
        "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
        "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
        "FILTER_NAME" => $filterName,
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
//        "CACHE_FILTER" => $arParams["CACHE_FILTER"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "SET_TITLE" => 'N',
        "MESSAGE_404" => $arParams["MESSAGE_404"],
        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
        "SHOW_404" => $arParams["SHOW_404"],
        "FILE_404" => $arParams["FILE_404"],
        "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
        "PAGE_ELEMENT_COUNT" => !empty($_COOKIE["countProducts"]) ? $_COOKIE["countProducts"] : $arParams["PAGE_ELEMENT_COUNT"],
        "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
        "PRICE_CODE" => $arParams["PRICE_CODE"],
        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
        "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
        "ADD_PROPERTIES_TO_BASKET" => ($arParams["ADD_PROPERTIES_TO_BASKET"] ?? ''),
        "PARTIAL_PRODUCT_PROPERTIES" => ($arParams["PARTIAL_PRODUCT_PROPERTIES"] ?? ''),
        "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

        "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE" => $arParams["PAGER_TITLE"],
        "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
        "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
        "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
        "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
        "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],

        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
        "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
        "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
        "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
        "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
        "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
        "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
        "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
        "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

        'LABEL_PROP' => $arParams['LABEL_PROP'],
        'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
        'PRODUCT_DISPLAY_MODE' => "N",

        'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
        'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
        'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
        'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
        'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
        'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
        'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
        'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
        'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
        'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

        'TEMPLATE_THEME' => ($arParams['TEMPLATE_THEME'] ?? ''),
        "ADD_SECTIONS_CHAIN" => 'N',
        'ADD_TO_BASKET_ACTION' => $basketAction,
        'SHOW_CLOSE_POPUP' => $arParams['COMMON_SHOW_CLOSE_POPUP'] ?? '',
        'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
        'SECTION_USER_FIELDS' => $arParams['SECTION_USER_FIELDS'],
        'NAV_STRING' => $paginator
    ),
    $component
);
?>
<div class="catalog-tx">
    <?= $arResult["SECTION"]["DESCRIPTION"] ?>
</div>