<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/* @var array $metaTags
 * @global CMain $APPLICATION
 */
if (empty($metaTags)){
    $APPLICATION->SetTitle('Моя корзина');
    $APPLICATION->SetPageProperty('description', 'Моя корзина');
}
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
                <h1><?= !empty($metaTags['TITLE']) ? $metaTags['TITLE'] : 'Моя корзина' ?></h1>
            </div>
        </div>
    </div>
<?php
$APPLICATION->IncludeComponent(
    "bitrix:sale.basket.basket",
    "main",
    array(
        "AFFETTA_PROMO" => COption::GetOptionString("affettapromo", "MODULE_ACTIVE", false) == 'Y',

        "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
        "COLUMNS_LIST" => array(
            0 => "NAME",
            1 => "DISCOUNT",
            2 => "PRICE",
            3 => "QUANTITY",
            4 => "SUM",
            5 => "PROPS",
            6 => "DELETE",
            7 => "DELAY",
        ),
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "PATH_TO_ORDER" => "/personal/order/",
        "HIDE_COUPON" => "N",
        "QUANTITY_FLOAT" => "Y",
        "PRICE_VAT_SHOW_VALUE" => "N",
        "TEMPLATE_THEME" => "site",
        "SET_TITLE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "OFFERS_PROPS" => array(),
        "COMPONENT_TEMPLATE" => "basket",
        "DEFERRED_REFRESH" => "N",
        "USE_DYNAMIC_SCROLL" => "Y",
        "SHOW_FILTER" => "Y",
        "SHOW_RESTORE" => "Y",
        "COLUMNS_LIST_EXT" => array(
            0 => "PREVIEW_PICTURE",
            1 => "PROPS",
            2 => "DELETE",
            3 => "SUM",
            4 => "PROPERTY_CML2_ARTICLE",
            5 => "PROPERTY_KLASS_IZNOSOSTOYKOSTI",
            6 => "PROPERTY_TSVET",
            7 => "PROPERTY_TOLSHCHINA_MM",
            8 => "PROPERTY_MATERIAL",
        ),
        "COLUMNS_LIST_MOBILE" => array(
            0 => "PREVIEW_PICTURE",
            1 => "DELETE",
            2 => "SUM",
            3 => "PROPERTY_CML2_ARTICLE",
            4 => "PROPERTY_KLASS_IZNOSOSTOYKOSTI",
            5 => "PROPERTY_TSVET",
            6 => "PROPERTY_TOLSHCHINA_MM",
            7 => "PROPERTY_MATERIAL",
        ),
        "TOTAL_BLOCK_DISPLAY" => array(
            0 => "bottom",
        ),
        "DISPLAY_MODE" => "extended",
        "PRICE_DISPLAY_MODE" => "Y",
        "SHOW_DISCOUNT_PERCENT" => "Y",
        "DISCOUNT_PERCENT_POSITION" => "top-left",
        "PRODUCT_BLOCKS_ORDER" => "props,sku,columns",
        "USE_PRICE_ANIMATION" => "Y",
        "LABEL_PROP" => array(),
        "USE_PREPAYMENT" => "N",
        "CORRECT_RATIO" => "Y",
        "AUTO_CALCULATION" => "Y",
        "ACTION_VARIABLE" => "basketAction",
        "COMPATIBLE_MODE" => "Y",
        "EMPTY_BASKET_HINT_PATH" => "/catalog/",
        "ADDITIONAL_PICT_PROP_1" => "-",
        "ADDITIONAL_PICT_PROP_2" => "-",
        "BASKET_IMAGES_SCALING" => "adaptive",
        "USE_GIFTS" => "Y",
        "GIFTS_PLACE" => "BOTTOM",
        "GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
        "GIFTS_HIDE_BLOCK_TITLE" => "N",
        "GIFTS_TEXT_LABEL_GIFT" => "Подарок",
        "GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
        "GIFTS_SHOW_OLD_PRICE" => "N",
        "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
        "GIFTS_MESS_BTN_BUY" => "Выбрать",
        "GIFTS_MESS_BTN_DETAIL" => "Подробнее",
        "GIFTS_PAGE_ELEMENT_COUNT" => "4",
        "GIFTS_CONVERT_CURRENCY" => "N",
        "GIFTS_HIDE_NOT_AVAILABLE" => "Y",
        "USE_ENHANCED_ECOMMERCE" => "N"
    ),
    false
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");