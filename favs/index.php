<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/* @var array $metaTags
 * @global CMain $APPLICATION
 */
if (empty($metaTags)) {
    $APPLICATION->SetTitle("Избранное");
    $APPLICATION->SetPageProperty('description', 'Избранное');
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
                <h1><?= !empty($metaTags['TITLE']) ? $metaTags['TITLE'] : 'Избранное' ?></h1>
            </div>
        </div>
    </div>
<?php if (empty($GLOBALS["FAVORITES"])): ?>
    <div class="all tw">
        <div class="container">
            <div class="all__inner">
                <div class="all__img"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/b2.png" alt=""></div>
                <div class="all__title">Избранных товаров пока нет</div>
                <div class="all__tx">На данный момент вы не добавили<br> ни одного товара в избранное</div>
                <div class="all__btn">
                    <a class="button button-black" href="<?= SITE_DIR ?>catalog/">Вернуться в каталог</a>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="fav tw">
        <div class="container">
            <div class="fav__inner">
                <div class="fav__close"><span>Удалить все</span>
                    <svg>
                        <use xlink:href="#close"></use>
                    </svg>
                </div>
                <div class="fav__page">
                    <div class="fav__page-left">
                        <?
                        $GLOBALS['arrFilter'] = array('ID' => $GLOBALS["FAVORITES"]);
                        $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section",
                            "search",
                            array(
                                "IBLOCK_ID" => "10",
                                "IBLOCK_TYPE" => "1c_catalog",
                                "FILTER_NAME" => "arrFilter",
                                "HIDE_NOT_AVAILABLE" => "Y",
                                "PRICE_CODE" => array(
                                    0 => "РРЦ",
                                ),
                                "ELEMENT_SORT_FIELD" => "sort",
                                "ELEMENT_SORT_ORDER" => "asc",
                                "INCLUDE_SUBSECTIONS" => "Y",
                                "SHOW_ALL_WO_SECTION" => "Y",
                                "PAGE_ELEMENT_COUNT" => "12",
                                "LINE_ELEMENT_COUNT" => "10",
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
                                "PAGER_TEMPLATE" => "main",
                                "DISPLAY_TOP_PAGER" => "N",
                                "DISPLAY_BOTTOM_PAGER" => "Y",
                                "PAGER_TITLE" => "Товары",
                                "PAGER_SHOW_ALWAYS" => "N",
                                "PAGER_DESC_NUMBERING" => "N",
                                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                "PAGER_SHOW_ALL" => "N",
                            )
                        );
                        unset($GLOBALS['arrFilter']);
                        ?>
                    </div>
                    <div class="fav__page-right">
                        <div class="propr__item propr__item-all">
                            <div class="propr__item-inner">
                                <div class="propr__item-all-title">Сохраняйте <br>в избранное <br>всё что вам
                                    понравилось
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
    <script>
        $('.fav__close').click(e => {
            BX.setCookie('favorites', '', {expires: -1, path: `/`});
            location.reload();
        });
    </script>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");