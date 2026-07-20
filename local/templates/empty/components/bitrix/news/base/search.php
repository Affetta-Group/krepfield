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
$this->setFrameMode(false);
$query_search = htmlspecialcharsEx($_REQUEST["q"]);
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
            <h1>База знаний</h1>
        </div>
    </div>
</div>
<div class="base-page">
    <div class="container">
        <div class="base-page__inner">
            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:search.title",
                "base",
                array(
                    "SHOW_INPUT" => "Y",
                    "INPUT_ID" => "title-search-input",
                    "CONTAINER_ID" => "title-search",
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PREVIEW_TRUNCATE_LEN" => "150",
                    "SHOW_PREVIEW" => "N",
                    "PREVIEW_WIDTH" => "75",
                    "PREVIEW_HEIGHT" => "75",
                    "CONVERT_CURRENCY" => "Y",
                    "CURRENCY_ID" => "RUB",
                    "PAGE" => "#SITE_DIR#knowledge-base/search/",
                    "NUM_CATEGORIES" => "1",
                    "TOP_COUNT" => "30",
                    "ORDER" => "date",
                    "USE_LANGUAGE_GUESS" => "N",
                    "CHECK_DATES" => "Т",
                    "SHOW_OTHERS" => "Y",
                    "CATEGORY_0_TITLE" => "База знаний",
                    "CATEGORY_0" => array(
                        0 => "iblock_content",
                    ),
                    "CATEGORY_0_iblock_books" => "all",
                    "COMPONENT_TEMPLATE" => "main",
                    "CATEGORY_0_iblock_1c_catalog" => array(
                        0 => "3",
                    ),

                ),
                false
            ); ?>
            <div class="base-page__zp">
                <div class="base-page__zp-title">Популярные запросы:</div>
                <? foreach ($arResult["QUERY"] as $query): ?>
                    <a class="base-page__zp-link"
                       href="<?= SITE_DIR ?>knowledge-base/search/?q=<?= $query ?>"><?= $query ?></a>
                <? endforeach; ?>
            </div>
        </div>
        <div class="base">
            <?
            $GLOBALS['arrFilter'] = array("%NAME" => $query_search);
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "search",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "QUERY" => $query_search,
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "TAGS_HIGHLOAD_ID" => $arParams["TAGS_HIGHLOAD_ID"],
                    "NEWS_COUNT" => $arParams["NEWS_COUNT"],
                    "SORT_BY1" => $arParams["SORT_BY1"],
                    "SORT_ORDER1" => $arParams["SORT_ORDER1"],
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
                    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
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
            unset($GLOBALS['arrFilter']);
            ?>
        </div>
    </div>
</div>

<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/advantage.php", Array(), Array("SHOW_BORDER"=>false));?>