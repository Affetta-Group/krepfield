<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */


require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/php/elastic/functions.php';

global $USER;


$perPage = (int)trim(!empty($_COOKIE["countProducts"]) ? trim($_COOKIE["countProducts"]) : $arParams["PAGE_ELEMENT_COUNT"]);
if ($perPage < 1) {
    $perPage = 20;
}
$page = (int)($_GET[$arParams['PAGINATOR_ID']] ?? 1);

/** Временное решение
 * отрезаем часть строки в запросе
 * при поиске по артикулу
 */

$query = strip_tags(trim($_GET['q']));
if (!empty(strstr($query, "-", true))) :
    $query = strstr($query, "-", true);
endif;
$lowerQuery = mb_strtolower($query);

//Исправляем раскладку
/*$excludeConvertKeyboard = ['шуруп', 'круг', 'бита', 'винт'];
$excluded = false;
foreach ($excludeConvertKeyboard as $word) {
    if (strpos($lowerQuery, $word) !== false) {
        $excluded = true;
        break;
    }
}
if (!$excluded) {
    $queryParts = explode(' ', $query);
    foreach ($queryParts as $key => $queryPart) {
        $arLang = CSearchLanguage::GuessLanguage($queryPart);
        if (is_array($arLang) && $arLang["from"] !== $arLang["to"]) {
            $queryParts[$key] = CSearchLanguage::ConvertKeyboardLayout($queryPart, $arLang["from"], $arLang["to"]);
        }
    }
    $query = implode(' ', $queryParts);
}*/

//Добавляем диаметр
$queryForOS = $query;
$labels = ['гайка', 'болт', 'шайба', 'колпачковая', 'шестигранная', 'плоская', 'самоконтрящаяся', 'нержавеющая'];
foreach ($labels as $label) {
    if (strpos($lowerQuery, $label) !== false) {
        $queryParts = explode(' ', $queryForOS);
        foreach ($queryParts as $queryPart) {
            if (is_numeric($queryPart)) {
                $queryForOS .= ' м' . $queryPart;
                break 2;
            }
        }
    }
}
// $result = search($queryForOS, $perPage, $page);
$openSearch = true;
try {
    $result = search($queryForOS, $perPage, $page);
    $resultFiltered = search($queryForOS, 10000, 1);
} catch (Exception $ex) {
    $openSearch = false;
    // $code = $ex->getCode();
    // $message = $ex->getMessage();
    // $file = $ex->getFile();
    // $line = $ex->getLine();
    // echo "Exception thrown in $file on line $line: [Code $code]
    // $message";
    // echo "<pre>Template arResult: "; print_r($message); echo "</pre>";
}
// rdd($result);
// echo "<pre>Template arResult: "; print_r($resultFiltered = search($queryForOS, 10000, 1)); echo "</pre>";
if ($openSearch) {
    if ($result['total'] < 1) { ?>
        <div class="all th tt">
            <div class="container">
                <div class="all__inner">
                    <div class="all__img"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/bl-n.png" alt=""></div>
                    <div class="all__title">По вашему запросу <span>“<?= htmlspecialchars($query) ?>”</span>
                        ничего не найдено
                    </div>
                    <div class="all__tx">К сожалению, по вашему запросу ничего не найдено. Проверьте<br>
                        правильность ввода или попробуйте изменить запрос
                    </div>
                    <div class="all__btn">
                        <a class="button button-black" href="<?= SITE_DIR ?>catalog/">Перейти в каталог</a>
                        <a class="button button-bord2" href="<?= SITE_DIR ?>">На главную</a></div>
                </div>
            </div>
        </div>
        <?php
        return;
    }


    $itemsIds = [0];
    $itemsIdsFilter = [0];
    foreach ($result['items'] as $item) {
        $itemsIds[] = (int)$item['_id'];
    }

    global $searchFilter;
    $searchFilter['ID'] = $itemsIds;

    foreach ($resultFiltered['items'] as $item) {
        $itemsIdsFilter[] = (int)$item['_id'];
    }
    global $searchFilterFiltered;
    $searchFilterFiltered['ID'] = $itemsIdsFilter;

    global $searchSectionFiltered;
    $i=0;
    foreach ($searchFilterFiltered['ID'] as $item) {
         $i++;


        $res = CIBlockElement::GetElementGroups($item);

        if ($ar_res = $res->GetNext()) {

            while (empty($ar_res['DEPTH_LEVEL']) && $ar_res['DEPTH_LEVEL'] != 4) {

                $res = CIBlockSection::GetById($ar_res['IBLOCK_SECTION_ID']);

                if ($ar_res2 = $res->GetNext()) {
                    $ar_res = $ar_res2;

                } else {
                    return;
                }

            }

            $searchSectionFiltered[$ar_res['CODE']] = array(
                "CODE" => $ar_res['CODE'],
                "NAME" => $ar_res['NAME'],
            );
        }

    }


    $nav = new \Bitrix\Main\UI\PageNavigation($arParams['PAGINATOR_ID']);
    $nav->allowAllRecords(false)
        ->setCurrentPage($page)
        ->setPageSize($perPage);
    $nav->setRecordCount($result['total']);


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
    $componentParams = array(
        "ELEMENT_SORT_FIELD" => "ID",
        "ELEMENT_SORT_ORDER" => $itemsIds,
        "ELEMENT_SORT_FIELD2" => "ID",
        "ELEMENT_SORT_ORDER2" => $itemsIds,
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
        "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
        "PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
        "PROPERTY_CODE_MOBILE" => (isset($arParams["PROPERTY_CODE_MOBILE"]) ? $arParams["PROPERTY_CODE_MOBILE"] : []),
        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
        "OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
        "OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
        "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
        "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
        "OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
        "SECTION_URL" => $arParams["SECTION_URL"],
        "DETAIL_URL" => $arParams["DETAIL_URL"],
        "BASKET_URL" => $arParams["BASKET_URL"],
        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
        "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
        "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
        "PRICE_CODE" => $arParams["~PRICE_CODE"],
        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
        "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
        "USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
        "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
        "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
        "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
        "CURRENCY_ID" => $arParams["CURRENCY_ID"],
        "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
        "HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
        "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE" => $arParams["PAGER_TITLE"],
        "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
        "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
        "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
        "LAZY_LOAD" => (isset($arParams["LAZY_LOAD"]) ? $arParams["LAZY_LOAD"] : 'N'),
        "MESS_BTN_LAZY_LOAD" => (isset($arParams["~MESS_BTN_LAZY_LOAD"]) ? $arParams["~MESS_BTN_LAZY_LOAD"] : ''),
        "LOAD_ON_SCROLL" => (isset($arParams["LOAD_ON_SCROLL"]) ? $arParams["LOAD_ON_SCROLL"] : 'N'),
        "SECTION_ID" => "",
        "SECTION_CODE" => "",
        "SECTION_USER_FIELDS" => array(),
        "INCLUDE_SUBSECTIONS" => "Y",
        "SHOW_ALL_WO_SECTION" => "Y",
        "META_KEYWORDS" => "",
        "META_DESCRIPTION" => "",
        "BROWSER_TITLE" => "",
        "ADD_SECTIONS_CHAIN" => "N",
        "SET_TITLE" => "N",
        "SET_STATUS_404" => "N",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "N",
        'LABEL_PROP' => (isset($arParams['LABEL_PROP']) ? $arParams['LABEL_PROP'] : ''),
        'LABEL_PROP_MOBILE' => (isset($arParams['LABEL_PROP_MOBILE']) ? $arParams['LABEL_PROP_MOBILE'] : ''),
        'LABEL_PROP_POSITION' => (isset($arParams['LABEL_PROP_POSITION']) ? $arParams['LABEL_PROP_POSITION'] : ''),
        'ADD_PICT_PROP' => (isset($arParams['ADD_PICT_PROP']) ? $arParams['ADD_PICT_PROP'] : ''),
        'PRODUCT_DISPLAY_MODE' => (isset($arParams['PRODUCT_DISPLAY_MODE']) ? $arParams['PRODUCT_DISPLAY_MODE'] : ''),
        'PRODUCT_BLOCKS_ORDER' => (isset($arParams['PRODUCT_BLOCKS_ORDER']) ? $arParams['PRODUCT_BLOCKS_ORDER'] : ''),
        'PRODUCT_ROW_VARIANTS' => (isset($arParams['PRODUCT_ROW_VARIANTS']) ? $arParams['PRODUCT_ROW_VARIANTS'] : ''),
        'ENLARGE_PRODUCT' => (isset($arParams['ENLARGE_PRODUCT']) ? $arParams['ENLARGE_PRODUCT'] : ''),
        'ENLARGE_PROP' => (isset($arParams['ENLARGE_PROP']) ? $arParams['ENLARGE_PROP'] : ''),
        'SHOW_SLIDER' => (isset($arParams['SHOW_SLIDER']) ? $arParams['SHOW_SLIDER'] : 'Y'),
        'SLIDER_INTERVAL' => (isset($arParams['SLIDER_INTERVAL']) ? $arParams['SLIDER_INTERVAL'] : '3000'),
        'SLIDER_PROGRESS' => (isset($arParams['SLIDER_PROGRESS']) ? $arParams['SLIDER_PROGRESS'] : 'N'),
        'OFFER_ADD_PICT_PROP' => (isset($arParams['OFFER_ADD_PICT_PROP']) ? $arParams['OFFER_ADD_PICT_PROP'] : ''),
        'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
        'PRODUCT_SUBSCRIPTION' => (isset($arParams['PRODUCT_SUBSCRIPTION']) ? $arParams['PRODUCT_SUBSCRIPTION'] : ''),
        'SHOW_DISCOUNT_PERCENT' => (isset($arParams['SHOW_DISCOUNT_PERCENT']) ? $arParams['SHOW_DISCOUNT_PERCENT'] : ''),
        'SHOW_OLD_PRICE' => (isset($arParams['SHOW_OLD_PRICE']) ? $arParams['SHOW_OLD_PRICE'] : ''),
        'SHOW_MAX_QUANTITY' => (isset($arParams['SHOW_MAX_QUANTITY']) ? $arParams['SHOW_MAX_QUANTITY'] : ''),
        'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
        'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
        'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
        'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
        'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
        'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
        'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
        'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
        'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
        'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),
        'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
        'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
        'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),
        'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
        'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
        'SHOW_CLOSE_POPUP' => (isset($arParams['SHOW_CLOSE_POPUP']) ? $arParams['SHOW_CLOSE_POPUP'] : ''),
        'COMPARE_PATH' => (isset($arParams['COMPARE_PATH']) ? $arParams['COMPARE_PATH'] : ''),
        'COMPARE_NAME' => (isset($arParams['COMPARE_NAME']) ? $arParams['COMPARE_NAME'] : ''),
        'USE_COMPARE_LIST' => (isset($arParams['USE_COMPARE_LIST']) ? $arParams['USE_COMPARE_LIST'] : ''),
        "FILTER_NAME" => "arrFilter",

    );
    ?>

    <div class="page-top">
        <div class="container">
            <div class="page-top__inner">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "main",
                    array(
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => "s1"
                    )
                );
                ?>
                <h1>По вашему запросу «<?= htmlspecialchars($query) ?>» найдено:</h1>
            </div>
        </div>
    </div>

    <div class="fav tw sr">
        <div class="container">
            <div class="catalog-page__inner">
                <div class="catalog-page__left">
                    <div class="filter__list tw">
                        <? foreach ($searchSectionFiltered as $item) { ?>
                            <div class="filter__title-t"><?= $item['NAME'] ?></div>
                            <?
                            $APPLICATION->IncludeComponent(
                                "custom:catalog.section.list",
                                "sections_menu_left",
                                array(
                                    "VIEW_MODE" => "TEXT",
                                    "SHOW_PARENT_NAME" => "Y",
                                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                    "SHOW_MORE" => 'N',
                                    "SECTION_ID" => "",
                                    "SECTION_CODE" => $item['CODE'],
                                    "SECTION_URL" => "",
                                    "COUNT_ELEMENTS" => "Y",
                                    "TOP_DEPTH" => "1",
                                    "SECTION_FIELDS" => array("SECTION_PAGE_URL", "PICTURE"),
                                    "SECTION_USER_FIELDS" => "",
                                    "ADD_SECTIONS_CHAIN" => "N",
                                    "FILTER_NAME" => "",
                                    "CACHE_TYPE" => "A",
                                    "CACHE_TIME" => "36000000",
                                    "CACHE_NOTES" => "",
                                    "CACHE_GROUPS" => "Y"
                                )
                            );
                        }
                        ?>
                    </div>
                    
                    <div class="filter__top-tt">Фильтр</div>
                    <?
                    
                    $APPLICATION->IncludeComponent(
                        "bitrix:catalog.smart.filter",
                        "main",
                        array(
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "CONVERT_CURRENCY" => "N",
                            "DISPLAY_ELEMENT_COUNT" => "Y",
                            "FILTER_NAME" => "arrFilter",
                            "FILTER_VIEW_MODE" => "vertical",
                            "HIDE_NOT_AVAILABLE" => "N",
                            "WHITE_LIST" => array(64, 62, 63, 65),
                            "IBLOCK_ID" => "10",
                            "IBLOCK_TYPE" => "1c_catalog",
                            "PAGER_PARAMS_NAME" => "arrPager",
                            "POPUP_POSITION" => "left",
                            "PREFILTER_NAME" => "searchFilterFiltered",
                            "PRICE_CODE" => array("РРЦ"),
                            "SAVE_IN_SESSION" => "N",
                            "SECTION_CODE" => "",
                            "SECTION_DESCRIPTION" => "-",
                            "SECTION_ID" => '',
                            "SECTION_TITLE" => "-",
                            "SEF_MODE" => "N",
                            "TEMPLATE_THEME" => "blue",
                            "XML_EXPORT" => "N"
                        )
                    );
                    ?>
                </div>
                <div class="catalog-page__content">
                    <div class="fav__inner">
                        <div class="fav__page">
                            <div class="fav__page-left">
                                <?php
                                $APPLICATION->IncludeComponent(
                                    "bitrix:catalog.section",
                                    "search",
                                    $componentParams,
                                    $arResult["THEME_COMPONENT"],
                                    array('HIDE_ICONS' => 'Y')
                                );
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
} else {
    
    if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y') {
        $basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '');
    } else {
        $basketAction = (isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '');
    }

    $APPLICATION->IncludeComponent(
        "bitrix:catalog.search",
        "main",
        array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
            "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
            "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
            "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
            "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
            "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
            "PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
            "PROPERTY_CODE_MOBILE" => isset($arParams["LIST_PROPERTY_CODE_MOBILE"]) ? $arParams["LIST_PROPERTY_CODE_MOBILE"] : '',
            "OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
            "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
            "OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
            "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
            "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
            "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
            "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
            "OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),
            "SECTION_URL" => $arParams["SECTION_URL"],
            "DETAIL_URL" => $arParams["DETAIL_URL"],
            "BASKET_URL" => $arParams["BASKET_URL"],
            "ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action"),
            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
            "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            'DISPLAY_COMPARE' => (isset($arParams['USE_COMPARE']) ? $arParams['USE_COMPARE'] : ''),
            "PRICE_CODE" => $arParams["~PRICE_CODE"],
            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
            "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
            "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
            "PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),
            "USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
            "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
            "CURRENCY_ID" => $arParams["CURRENCY_ID"],
            'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
            'HIDE_NOT_AVAILABLE_OFFERS' => isset($arParams["HIDE_NOT_AVAILABLE_OFFERS"]) ? $arParams["HIDE_NOT_AVAILABLE_OFFERS"] : '',
            "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
            "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
            "PAGER_TITLE" => $arParams["PAGER_TITLE"],
            "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
            "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
            "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
            "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
            "LAZY_LOAD" => isset($arParams["LAZY_LOAD"]) ? $arParams["LAZY_LOAD"] : '',
            "MESS_BTN_LAZY_LOAD" => isset($arParams["~MESS_BTN_LAZY_LOAD"]) ? $arParams["~MESS_BTN_LAZY_LOAD"] : '',
            "LOAD_ON_SCROLL" => isset($arParams["LOAD_ON_SCROLL"]) ? $arParams["LOAD_ON_SCROLL"] : '',
            "FILTER_NAME" => "searchFilter",
            "SECTION_ID" => "",
            "SECTION_CODE" => "",
            "SECTION_USER_FIELDS" => array(),
            "INCLUDE_SUBSECTIONS" => "Y",
            "SHOW_ALL_WO_SECTION" => "Y",
            "META_KEYWORDS" => "",
            "META_DESCRIPTION" => "",
            "BROWSER_TITLE" => "",
            "ADD_SECTIONS_CHAIN" => "N",
            "SET_TITLE" => "N",
            "SET_STATUS_404" => "N",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "N",

            "PAGE_RESULT_COUNT" => !empty($arParams["SEARCH_PAGE_RESULT_COUNT"]) ? $arParams["SEARCH_PAGE_RESULT_COUNT"] : "50",
            "RESTART" => !empty($arParams["SEARCH_RESTART"]) ? $arParams["SEARCH_RESTART"] : "N",
            "NO_WORD_LOGIC" => !empty($arParams["SEARCH_NO_WORD_LOGIC"]) ? $arParams["SEARCH_NO_WORD_LOGIC"] : "Y",
            "USE_LANGUAGE_GUESS" => "N",
            "CHECK_DATES" => !empty($arParams["SEARCH_CHECK_DATES"]) ? $arParams["SEARCH_CHECK_DATES"] : "Y",

            'LABEL_PROP' => $arParams['LABEL_PROP'],
            'LABEL_PROP_MOBILE' => isset($arParams['LABEL_PROP_MOBILE']) ? $arParams['LABEL_PROP_MOBILE'] : '',
            'LABEL_PROP_POSITION' => isset($arParams['LABEL_PROP_POSITION']) ? $arParams['LABEL_PROP_POSITION'] : '',
            'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
            'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
            'PRODUCT_BLOCKS_ORDER' => isset($arParams['LIST_PRODUCT_BLOCKS_ORDER']) ? $arParams['LIST_PRODUCT_BLOCKS_ORDER'] : '',
            'PRODUCT_ROW_VARIANTS' => isset($arParams['LIST_PRODUCT_ROW_VARIANTS']) ? $arParams['LIST_PRODUCT_ROW_VARIANTS'] : '',
            'ENLARGE_PRODUCT' => isset($arParams['LIST_ENLARGE_PRODUCT']) ? $arParams['LIST_ENLARGE_PRODUCT'] : '',
            'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
            'SHOW_SLIDER' => isset($arParams['LIST_SHOW_SLIDER']) ? $arParams['LIST_SHOW_SLIDER'] : '',
            'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
            'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

            'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
            'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
            'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
            'SHOW_MAX_QUANTITY' => (isset($arParams['SHOW_MAX_QUANTITY']) ? $arParams['SHOW_MAX_QUANTITY'] : ''),
            'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
            'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
            'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
            'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
            'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
            'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
            'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
            'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
            'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE'],
            'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

            'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
            'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
            'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

            'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
            'ADD_TO_BASKET_ACTION' => $basketAction,
            'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
            'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
            'COMPARE_NAME' => $arParams['COMPARE_NAME'],
            'USE_COMPARE_LIST' => 'Y',
            'USE_SEARCH_RESULT_ORDER' => 'N',
        ),
        $component,
        array("HIDE_ICONS" => "Y")
    );
    unset($basketAction);
} ?>