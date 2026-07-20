<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $arCurSection
 */
?>
<div class="catalog-page">
	<div class="container">
		<div class="catalog-page__inner" itemscope itemtype="http://schema.org/Product">
			<div class="catalog-page__left">
				<? $APPLICATION->IncludeComponent(
					"custom:catalog.section.list",
					"catalog",
					array(
						"VIEW_MODE" => "TEXT",
						"SHOW_PARENT_NAME" => "Y",
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"SECTION_ID" => "",
						"SECTION_CODE" => "",
						"SECTION_URL" => "",
						"COUNT_ELEMENTS" => "Y",
						"TOP_DEPTH" => "5",
						"SECTION_FIELDS" => array("SECTION_PAGE_URL"),
						"SECTION_USER_FIELDS" => "",
						"ADD_SECTIONS_CHAIN" => "Y",
						"CACHE_TYPE" => "A",
						"CACHE_TIME" => "36000000",
						"CACHE_NOTES" => "",
						"CACHE_GROUPS" => "Y"
					)
				); ?>
			</div>
			<div class="catalog-page__content">
				<div class="catalog-main">
                    <?
                    $APPLICATION->IncludeComponent(
                        "custom:catalog.section.list",
                        "sections",
                        array(
                            "VIEW_MODE" => "TEXT",
                            "SHOW_PARENT_NAME" => "Y",
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "SECTION_ID" => "",
                            "SECTION_CODE" => $arResult["SECTION"]["CODE"],
                            "SECTION_URL" => "",
                            "COUNT_ELEMENTS" => "Y",
                            "TOP_DEPTH" => "1",
                            "SECTION_FIELDS" => array("SECTION_PAGE_URL", "PICTURE"),
                            "SECTION_USER_FIELDS" => array('UF_PIC_CATALOG_SVG'),
                            "ADD_SECTIONS_CHAIN" => "Y",
                            "FILTER_NAME" => $arParams["FILTER_NAME"],
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_NOTES" => "",
                            "CACHE_GROUPS" => "Y"
                        )
                    );
                    ?>
				</div>

                <? include('includes/sort_line.php'); ?>

                <? include('includes/catalog_section.php'); ?>

					<?php
                    $GLOBALS["arrHitFilter"] = array("PROPERTY_KHIT_VALUE" => "Да", ">CATALOG_PRICE_1" => 0);
					$APPLICATION->IncludeComponent(
						"bitrix:catalog.section",
						"main",
						array(
                            "ACTION_VARIABLE" => "action",
                            "ADD_PICT_PROP" => "MORE_PHOTO",
                            "ADD_PROPERTIES_TO_BASKET" => "Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "ADD_TO_BASKET_ACTION" => "ADD",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "BACKGROUND_IMAGE" => "UF_BACKGROUND_IMAGE",
                            "BASKET_URL" => "/personal/basket.php",
                            "BRAND_PROPERTY" => "BRAND_REF",
                            "BROWSER_TITLE" => "-",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "COMPATIBLE_MODE" => "Y",
                            "CONVERT_CURRENCY" => "Y",
                            "CURRENCY_ID" => "RUB",
                            "CUSTOM_FILTER" => "",
                            "DATA_LAYER_NAME" => "dataLayer",
                            "DETAIL_URL" => "",
                            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                            "DISCOUNT_PERCENT_POSITION" => "bottom-right",
                            "DISPLAY_BOTTOM_PAGER" => "N",
                            "DISPLAY_TOP_PAGER" => "N",
                            "ELEMENT_SORT_FIELD" => "sort",
                            "ELEMENT_SORT_FIELD2" => "id",
                            "ELEMENT_SORT_ORDER" => "asc",
                            "ELEMENT_SORT_ORDER2" => "desc",
                            "ENLARGE_PRODUCT" => "PROP",
                            "ENLARGE_PROP" => "NEWPRODUCT",
                            "FILTER_NAME" => "arrHitFilter",
                            "HIDE_NOT_AVAILABLE" => "N",
                            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "IBLOCK_TYPE" =>  $arParams["IBLOCK_TYPE"],
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "LABEL_PROP" => array("NEWPRODUCT"),
                            "LABEL_PROP_MOBILE" => array(),
                            "LABEL_PROP_POSITION" => "top-left",
                            "LAZY_LOAD" => "Y",
                            "LINE_ELEMENT_COUNT" => "3",
                            "LOAD_ON_SCROLL" => "N",
                            "MESSAGE_404" => "",
                            "MESS" => "Хиты в этой категории",
                            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                            "MESS_BTN_BUY" => "Купить",
                            "MESS_BTN_DETAIL" => "Подробнее",
                            "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                            "MESS_BTN_SUBSCRIBE" => "Подписаться",
                            "MESS_NOT_AVAILABLE" => "Нет в наличии",
                            "META_DESCRIPTION" => "-",
                            "META_KEYWORDS" => "-",
                            "OFFERS_CART_PROPERTIES" => array("ARTNUMBER","COLOR_REF","SIZES_SHOES","SIZES_CLOTHES"),
                            "OFFERS_FIELD_CODE" => array("",""),
                            "OFFERS_LIMIT" => "5",
                            "OFFERS_PROPERTY_CODE" => array("COLOR_REF","SIZES_SHOES","SIZES_CLOTHES",""),
                            "OFFERS_SORT_FIELD" => "sort",
                            "OFFERS_SORT_FIELD2" => "id",
                            "OFFERS_SORT_ORDER" => "asc",
                            "OFFERS_SORT_ORDER2" => "desc",
                            "OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
                            "OFFER_TREE_PROPS" => array("COLOR_REF","SIZES_SHOES","SIZES_CLOTHES"),
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => ".default",
                            "PAGER_TITLE" => "Товары",
                            "PAGE_ELEMENT_COUNT" => "18",
                            "PARTIAL_PRODUCT_PROPERTIES" => "N",
                            "PRICE_CODE" => $arParams["PRICE_CODE"],
                            "PRICE_VAT_INCLUDE" => "Y",
                            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
                            "PRODUCT_DISPLAY_MODE" => "Y",
                            "PRODUCT_ID_VARIABLE" => "id",
                            "PRODUCT_PROPERTIES" => array("NEWPRODUCT","MATERIAL"),
                            "PRODUCT_PROPS_VARIABLE" => "prop",
                            "PRODUCT_QUANTITY_VARIABLE" => "",
                            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':true}]",
                            "PRODUCT_SUBSCRIPTION" => "Y",
                            "PROPERTY_CODE" => array("NEWPRODUCT",""),
                            "PROPERTY_CODE_MOBILE" => array(),
                            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                            "RCM_TYPE" => "personal",
                            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                            "SECTION_ID_VARIABLE" => "SECTION_ID",
                            "SECTION_URL" => "",
                            "SECTION_USER_FIELDS" => array("",""),
                            "SEF_MODE" => "N",
                            "SET_BROWSER_TITLE" => "Y",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "Y",
                            "SET_META_KEYWORDS" => "Y",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SHOW_ALL_WO_SECTION" => "N",
                            "SHOW_CLOSE_POPUP" => "N",
                            "SHOW_DISCOUNT_PERCENT" => "Y",
                            "SHOW_FROM_SECTION" => "N",
                            "SHOW_MAX_QUANTITY" => "N",
                            "SHOW_OLD_PRICE" => "N",
                            "SHOW_PRICE_COUNT" => "1",
                            "SHOW_SLIDER" => "Y",
                            "SLIDER_INTERVAL" => "3000",
                            "SLIDER_PROGRESS" => "N",
                            "TEMPLATE_THEME" => "blue",
                            "USE_ENHANCED_ECOMMERCE" => "Y",
                            "USE_MAIN_ELEMENT_SECTION" => "N",
                            "USE_PRICE_COUNT" => "N",
                            "USE_PRODUCT_QUANTITY" => "N"
						),
						false
					);
                    unset($GLOBALS["arrHitFilter"]);
					?>
					<?php
                    $GLOBALS["arrNewFilter"] = array("PROPERTY_NEW_VALUE" => "Да", ">CATALOG_PRICE_1" => 0);
					$APPLICATION->IncludeComponent(
						"bitrix:catalog.section",
						"main",
						array(
                            "ACTION_VARIABLE" => "action",
                            "ADD_PICT_PROP" => "MORE_PHOTO",
                            "ADD_PROPERTIES_TO_BASKET" => "Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "ADD_TO_BASKET_ACTION" => "ADD",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "BACKGROUND_IMAGE" => "UF_BACKGROUND_IMAGE",
                            "BASKET_URL" => "/personal/basket.php",
                            "BRAND_PROPERTY" => "BRAND_REF",
                            "BROWSER_TITLE" => "-",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "COMPATIBLE_MODE" => "Y",
                            "CONVERT_CURRENCY" => "Y",
                            "CURRENCY_ID" => "RUB",
                            "CUSTOM_FILTER" => "",
                            "DATA_LAYER_NAME" => "dataLayer",
                            "DETAIL_URL" => "",
                            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                            "DISCOUNT_PERCENT_POSITION" => "bottom-right",
                            "DISPLAY_BOTTOM_PAGER" => "N",
                            "DISPLAY_TOP_PAGER" => "N",
                            "ELEMENT_SORT_FIELD" => "sort",
                            "ELEMENT_SORT_FIELD2" => "id",
                            "ELEMENT_SORT_ORDER" => "asc",
                            "ELEMENT_SORT_ORDER2" => "desc",
                            "ENLARGE_PRODUCT" => "PROP",
                            "ENLARGE_PROP" => "NEWPRODUCT",
                            "FILTER_NAME" => "arrNewFilter",
                            "HIDE_NOT_AVAILABLE" => "N",
                            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "IBLOCK_TYPE" =>  $arParams["IBLOCK_TYPE"],
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "LABEL_PROP" => array("NEWPRODUCT"),
                            "LABEL_PROP_MOBILE" => array(),
                            "LABEL_PROP_POSITION" => "top-left",
                            "LAZY_LOAD" => "Y",
                            "LINE_ELEMENT_COUNT" => "3",
                            "LOAD_ON_SCROLL" => "N",
                            "MESSAGE_404" => "",
                            "MESS" => "Новинки в этой категории",
                            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                            "MESS_BTN_BUY" => "Купить",
                            "MESS_BTN_DETAIL" => "Подробнее",
                            "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                            "MESS_BTN_SUBSCRIBE" => "Подписаться",
                            "MESS_NOT_AVAILABLE" => "Нет в наличии",
                            "META_DESCRIPTION" => "-",
                            "META_KEYWORDS" => "-",
                            "OFFERS_CART_PROPERTIES" => array("ARTNUMBER","COLOR_REF","SIZES_SHOES","SIZES_CLOTHES"),
                            "OFFERS_FIELD_CODE" => array("",""),
                            "OFFERS_LIMIT" => "5",
                            "OFFERS_PROPERTY_CODE" => array("COLOR_REF","SIZES_SHOES","SIZES_CLOTHES",""),
                            "OFFERS_SORT_FIELD" => "sort",
                            "OFFERS_SORT_FIELD2" => "id",
                            "OFFERS_SORT_ORDER" => "asc",
                            "OFFERS_SORT_ORDER2" => "desc",
                            "OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
                            "OFFER_TREE_PROPS" => array("COLOR_REF","SIZES_SHOES","SIZES_CLOTHES"),
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => ".default",
                            "PAGER_TITLE" => "Товары",
                            "PAGE_ELEMENT_COUNT" => "18",
                            "PARTIAL_PRODUCT_PROPERTIES" => "N",
                            "PRICE_CODE" => $arParams["PRICE_CODE"],
                            "PRICE_VAT_INCLUDE" => "Y",
                            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
                            "PRODUCT_DISPLAY_MODE" => "Y",
                            "PRODUCT_ID_VARIABLE" => "id",
                            "PRODUCT_PROPERTIES" => array("NEWPRODUCT","MATERIAL"),
                            "PRODUCT_PROPS_VARIABLE" => "prop",
                            "PRODUCT_QUANTITY_VARIABLE" => "",
                            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':true}]",
                            "PRODUCT_SUBSCRIPTION" => "Y",
                            "PROPERTY_CODE" => array("NEWPRODUCT",""),
                            "PROPERTY_CODE_MOBILE" => array(),
                            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                            "RCM_TYPE" => "personal",
                            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                            "SECTION_ID_VARIABLE" => "SECTION_ID",
                            "SECTION_URL" => "",
                            "SECTION_USER_FIELDS" => array("",""),
                            "SEF_MODE" => "N",
                            "SET_BROWSER_TITLE" => "Y",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "Y",
                            "SET_META_KEYWORDS" => "Y",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SHOW_ALL_WO_SECTION" => "N",
                            "SHOW_CLOSE_POPUP" => "N",
                            "SHOW_DISCOUNT_PERCENT" => "Y",
                            "SHOW_FROM_SECTION" => "N",
                            "SHOW_MAX_QUANTITY" => "N",
                            "SHOW_OLD_PRICE" => "N",
                            "SHOW_PRICE_COUNT" => "1",
                            "SHOW_SLIDER" => "Y",
                            "SLIDER_INTERVAL" => "3000",
                            "SLIDER_PROGRESS" => "N",
                            "TEMPLATE_THEME" => "blue",
                            "USE_ENHANCED_ECOMMERCE" => "Y",
                            "USE_MAIN_ELEMENT_SECTION" => "N",
                            "USE_PRICE_COUNT" => "N",
                            "USE_PRODUCT_QUANTITY" => "N"
						),
						false
					);
                    unset($GLOBALS["arrNewFilter"]);
					?>
                <? if (strlen($GLOBALS['SEO_TEXT_HTML']) > 5 && !strpos($_SERVER['REQUEST_URI'], '?PAGEN')) {?>
                    <div class="catalog-tx text-af" data-more-text="main">
                        <?=$GLOBALS['SEO_TEXT_HTML']?>
                        <span class="button button-more button-primary" data-more-text="btn">
                            <span class="button__name" data-more-text="btn-name">Показать еще</span>
                            <svg>
                                <use xlink:href="#arrow"></use>
                            </svg>
                        </span>
                    </div>
                <? } ?>
			</div>
		</div>
	</div>
</div>

<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/advantage.php", Array(), Array("SHOW_BORDER"=>false));?>