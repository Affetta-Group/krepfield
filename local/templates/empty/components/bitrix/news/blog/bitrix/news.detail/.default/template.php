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
$this->setFrameMode(true);
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
            <h1><?= $arResult["NAME"] ?></h1>
        </div>
    </div>
</div>
<div class="article">
    <div class="container">
        <div class="article__inner">
            <div class="article__about">
                <div class="article__tx">
                    <? if (!empty($arResult["DETAIL_PICTURE"])): ?>
                        <div class="article__tx-img"
                             style="background-image: url('<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>')">
                        </div>
                    <? endif; ?>
                    <? if (!empty($arResult["DISPLAY_ACTIVE_FROM"])): ?>
                        <div class="article__tx-data"><?= $arResult["DISPLAY_ACTIVE_FROM"] ?></div>
                    <? endif; ?>
                    <?= $arResult["DETAIL_TEXT"] ?>
                </div>
            </div>
             <?
                $GLOBALS["arrFilter"] = array("!ID" => $arResult["ID"]);
                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "another",
                    array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "NEWS_COUNT" => "3",
                        "SORT_BY1" => "RAND",
                        "SORT_ORDER1" => "RAND",
                        "SORT_BY2" => $arParams["SORT_BY2"],
                        "SORT_ORDER2" => $arParams["SORT_ORDER2"],
                        "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
                        "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                        "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
                        "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                        "IBLOCK_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
                        "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
                        "SET_TITLE" => $arParams["SET_TITLE"],
                        "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                        "MESSAGE_404" => $arParams["MESSAGE_404"],
                        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                        "SHOW_404" => $arParams["SHOW_404"],
                        "FILE_404" => $arParams["FILE_404"],
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                        "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                        "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                        "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                        "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                        "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                        "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                        "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                        "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
                        "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
                        "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
                        "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
                        "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
                        "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
                        "FILTER_NAME" => "arrFilter",
                        "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                        "CHECK_DATES" => $arParams["CHECK_DATES"],
                    ),
                    $component
                );
                unset($GLOBALS["arrFilter"]);
                ?>

        </div>
    </div>
</div>
<?php if (!empty($arResult['PROPERTIES']['PRODUCTS']['VALUE'])):?>
<div class="catalog-slider tw">
    <div class="container">
        <div class="catalog-slider__bg">
            <h2>Сопутствующие товары</h2>
            <?php
            $GLOBALS["arrFilter"] = array("ID" => $arResult['PROPERTIES']['PRODUCTS']['VALUE']);
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "recommend",
                array(
                    "IBLOCK_ID" => "10",
                    "IBLOCK_TYPE" => "1c_catalog",
                    "IBLOCK_SECTION_ID" => "",
                    "FILTER_NAME" => "arrFilter",
                    "HIDE_NOT_AVAILABLE" => "Y",
                    "PRICE_CODE" => array(
                        0 => "РРЦ",
                    ),
                    "ELEMENT_SORT_FIELD" => "sort",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "PAGE_ELEMENT_COUNT" => "20",
                    "LINE_ELEMENT_COUNT" => "20",
                    "PROPERTY_CODE" => array("SHIRINA_1"),
                    "OFFERS_LIMIT" => "0",
                    "SECTION_URL" => "",
                    "DETAIL_URL" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_GROUPS" => "Y",
                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "SET_STATUS_404" => "N",
                    "CACHE_FILTER" => "N",
                    "ACTION_VARIABLE" => "action",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "USE_PRICE_COUNT" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "PRICE_VAT_INCLUDE" => "Y",
                    "CONVERT_CURRENCY" => "N",
                    "BASKET_URL" => "/personal/basket.php",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRODUCT_PROPERTIES" => array(),
                    "DISPLAY_COMPARE" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Товары",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                ),
                false
            );
            unset($GLOBALS["arrFilter"]); ?>
        </div>
    </div>
</div>
<?php endif;?>

<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/advantage.php", Array(), Array("SHOW_BORDER"=>false));?>
