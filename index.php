<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/antibot/code/include.php');
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
/* @var array $metaTags
 * @global CMain $APPLICATION
 */
$APPLICATION->SetTitle('Нержавеющий крепеж — купить по выгодной цене в KREPFIELD');

if (empty($metaTags)) {
    $APPLICATION->SetTitle($metaTags['Главная']);
    $APPLICATION->SetPageProperty('description', 'Главная');
}
?>
    <div class="banner">
        <div class="container">
            <? $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "banners",
                array(
                    "DISPLAY_DATE" => "Y",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "AJAX_MODE" => "N",
                    "IBLOCK_TYPE" => "content",
                    "IBLOCK_ID" => "4",
                    "NEWS_COUNT" => "10",
                    "SORT_BY1" => "SORT",
                    "SORT_ORDER1" => "ASC",
                    "SORT_BY2" => "ID",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "",
                    "FIELD_CODE" => array("ID"),
                    "PROPERTY_CODE" => array("DESCRIPTION"),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_LAST_MODIFIED" => "Y",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "Y",
                    "DISPLAY_TOP_PAGER" => "Y",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "PAGER_TITLE" => "Новости",
                    "PAGER_SHOW_ALWAYS" => "Y",
                    "PAGER_TEMPLATE" => "",
                    "PAGER_DESC_NUMBERING" => "Y",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "Y",
                    "PAGER_BASE_LINK_ENABLE" => "Y",
                    "SET_STATUS_404" => "Y",
                    "SHOW_404" => "N",
                    "MESSAGE_404" => "",
                    "PAGER_BASE_LINK" => "",
                    "PAGER_PARAMS_NAME" => "arrPager",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => ""
                )
            ); ?>
        </div>
    </div>
    <div class="av">
        <div class="container">
            <div class="av__inner">
                <a class="av__item" href="#ab">
                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/icon1.svg" alt="Преимущество KREPFIELD 1" title="Достоинства интернет-магазина KREPFIELD 1"><span>Почему<br> нержавейка?</span>
                </a>
                <div class="av__item">
                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/icon2.svg" alt="Преимущество KREPFIELD 2" title="Достоинства интернет-магазина KREPFIELD 2"><span>Весь товар <br>сертифицирован</span>
                </div>
                <div class="av__item">
                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/icon3.svg" alt="Преимущество KREPFIELD 3" title="Достоинства интернет-магазина KREPFIELD 3"><span>Удобная и быстрая<br> доставка</span>
                </div>
                <div class="av__item">
                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/icon4.svg" alt="Преимущество KREPFIELD 4" title="Достоинства интернет-магазина KREPFIELD 4"><span>Персональный <br> консультант</span>
                </div>
                <div class="av__item">
                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/icon5.svg" alt="Преимущество KREPFIELD 5" title="Достоинства интернет-магазина KREPFIELD 5"><span>Комплексные <br>решения</span>
                </div>
            </div>
        </div>
    </div>
<!--
    <div class="propr propr-all">
        <div class="container">
            <div class="title-main">
                <h2>Предложения по крепежу</h2><a class="title-main-arrow" href="<?= SITE_DIR ?>specialists/">
                    <svg>
                        <use xlink:href="#arrow"></use>
                    </svg>
                </a>
            </div>
            <div class="propr__inner">
                <div class="propr__item propr__item-all">
                    <div class="propr__item-inner">
                        <div class="propr__item-all-title">ваша<br> профессия</div>
                        <a class="propr__item-all-link" href="<?= SITE_DIR ?>specialists/">более 150 решений
                            <svg>
                                <use xlink:href="#arrow"></use>
                            </svg>
                        </a>
                    </div>
                </div>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "specialists_main",
                    array(
                        "VIEW_MODE" => "TEXT",
                        "SHOW_PARENT_NAME" => "Y",
                        "IBLOCK_TYPE" => "content",
                        "IBLOCK_ID" => "5",
                        "SECTION_ID" => "",
                        "SECTION_CODE" => "",
                        "SECTION_URL" => "",
                        "COUNT_ELEMENTS" => "Y",
                        "TOP_DEPTH" => "1",
                        "SECTION_FIELDS" => "",
                        "SECTION_USER_FIELDS" => "",
                        "ADD_SECTIONS_CHAIN" => "Y",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "CACHE_NOTES" => "",
                        "CACHE_GROUPS" => "Y"
                    )
                ); ?>
            </div>
        </div>
    </div> -->
<div class="catalog-min">
        <div class="container">
            <p class="title-h2">Хиты маркетплейсов</p>
            <? 
            $GLOBALS["arrHITFilter"] = array("=PROPERTY_KF_DLYA_SAYTA_KHIT" => "Да");
            // $GLOBALS["arrHITFilter"] = array("ID" => "66");
            
           $APPLICATION->IncludeComponent(
            "bitrix:catalog.section",
            "main_page_sections_c",
            array(
                "IBLOCK_ID" => 10,
                "IBLOCK_TYPE" =>  "1c_catalog",
                "FILTER_NAME" => "arrHITFilter",
                // "SECTION_ID" => $arResult["SECTION"]["ID"],
                "HIDE_NOT_AVAILABLE" => "Y",
                "PRICE_CODE" => array(
                    0 => "РРЦ",
                ),
                "ELEMENT_SORT_FIELD" => "sort",
                "ELEMENT_SORT_ORDER" => "desc",
                "INCLUDE_SUBSECTIONS" => "Y",
                "SHOW_ALL_WO_SECTION" => "Y",
                "PAGE_ELEMENT_COUNT" => "100",
                "LINE_ELEMENT_COUNT" => "6",
                "PROPERTY_CODE" => array("KF_DLYA_SAYTA_NAIMENOVANIE"),
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
            ?>
        </div>
    </div>
    <div class="catalog-min">
        <div class="container">
            <p class="title-h2">Комплекты</p>
            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "main_page_sections",
                array(
                    "VIEW_MODE" => "TEXT",
                    "TITLE"=>"Комплекты",
                    // "FILTER" => "Y",
                    "SHOW_PARENT_NAME" => "Y",
                    "IBLOCK_TYPE" => "1c_catalog",
                    "IBLOCK_ID" => "10",
                    "SECTION_ID" => "783",
                    "SECTION_CODE" => "",
                    "SECTION_URL" => "",
                    "COUNT_ELEMENTS" => "Y",
                    "TOP_DEPTH" => "1",
                    "SECTION_FIELDS" => "",
                    "SECTION_USER_FIELDS" => array('UF_*'),
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "CACHE_TYPE" => "N",
                    "CACHE_TIME" => "36000000",
                    "CACHE_NOTES" => "",
                    "CACHE_GROUPS" => "Y"
                )
            ); ?>
        </div>
    </div>
    <div class="catalog-min">
        <div class="container">
            <p class="title-h2">Ограждения</p>
            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "main_page_sections",
                array(
                    "VIEW_MODE" => "TEXT",
                    // "FILTER" => "Y",
                    "TITLE"=>"Ограждения",
                    "SHOW_PARENT_NAME" => "Y",
                    "IBLOCK_TYPE" => "1c_catalog",
                    "IBLOCK_ID" => "10",
                    "SECTION_ID" => "4023",
                    "SECTION_CODE" => "",
                    "SECTION_URL" => "",
                    "COUNT_ELEMENTS" => "Y",
                    "TOP_DEPTH" => "1",
                    "SECTION_FIELDS" => "",
                    "SECTION_USER_FIELDS" => array('UF_*'),
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "CACHE_TYPE" => "N",
                    "CACHE_TIME" => "36000000",
                    "CACHE_NOTES" => "",
                    "CACHE_GROUPS" => "Y"
                )
            ); ?>
        </div>
    </div>

    <div class="catalog-min">
        <div class="container">
            <p class="title-h2">Купить крепежные изделия из нержавейки</p>
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "main_page_sections",
                array(
                    "VIEW_MODE" => "TEXT",
                    "SHOW_PARENT_NAME" => "Y",
                    "IBLOCK_TYPE" => "1c_catalog",
                    "IBLOCK_ID" => "10",
                    "FILTER" => "Y",
                    "SECTION_ID" => "104",
                    "SECTION_CODE" => "",
                    "SECTION_URL" => "",
                    "COUNT_ELEMENTS" => "Y",
                    "TOP_DEPTH" => "1",
                    "SECTION_FIELDS" => "",
                    "SECTION_USER_FIELDS" => array('UF_*'),
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "CACHE_TYPE" => "N",
                    "CACHE_TIME" => "36000000",
                    "CACHE_NOTES" => "",
                    "CACHE_GROUPS" => "Y"
                )
            ); ?>
        </div>
    </div>
    <div class="catalog-min">
        <div class="container">
            <p class="title-h2">Такелаж из нержавеющей стали</p>
            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "main_page_sections",
                array(
                    "VIEW_MODE" => "TEXT",
                    "FILTER" => "Y",
                    "SHOW_PARENT_NAME" => "Y",
                    "IBLOCK_TYPE" => "1c_catalog",
                    "IBLOCK_ID" => "10",
                    "SECTION_ID" => "88",
                    "SECTION_CODE" => "",
                    "SECTION_URL" => "",
                    "COUNT_ELEMENTS" => "Y",
                    "TOP_DEPTH" => "1",
                    "SECTION_FIELDS" => "",
                    "SECTION_USER_FIELDS" => array('UF_*'),
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "CACHE_TYPE" => "N",
                    "CACHE_TIME" => "36000000",
                    "CACHE_NOTES" => "",
                    "CACHE_GROUPS" => "Y"
                )
            ); ?>
        </div>
    </div>
    <div class="catalog-min">
        <div class="container">
            <p class="title-h2">Оснастка для любых целей</p>
            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "main_page_sections",
                array(
                    "VIEW_MODE" => "TEXT",
                    "SHOW_PARENT_NAME" => "Y",
                    "FILTER" => "Y",
                    "IBLOCK_TYPE" => "1c_catalog",
                    "IBLOCK_ID" => "10",
                    "SECTION_ID" => "129",
                    "SECTION_CODE" => "",
                    "SECTION_URL" => "",
                    "COUNT_ELEMENTS" => "Y",
                    "TOP_DEPTH" => "1",
                    "SECTION_FIELDS" => "",
                    "SECTION_USER_FIELDS" => array('UF_*'),
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "CACHE_TYPE" => "N",
                    "CACHE_TIME" => "36000000",
                    "CACHE_NOTES" => "",
                    "CACHE_GROUPS" => "Y"
                )
            ); ?>
        </div>
    </div>



    <!-- Скрытый блок
    <div class="propr">
        <div class="container">
            <div class="title-main">
                <h2>Готовые решения</h2>
            </div>
            <div class="propr__inner">
                <div class="propr__item"><a class="propr__item-inner" href="#"
                                            style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/img5.jpg')"><span
                                class="propr__item-bottom"><span>Ванная комната</span><img
                                    src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/arrow.svg" alt=""></span></a></div>
                <div class="propr__item"><a class="propr__item-inner" href="#"
                                            style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/img6.jpg')"><span
                                class="propr__item-bottom"><span>Гостиная</span><img
                                    src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/arrow.svg"
                                    alt=""></span></a></div>
                <div class="propr__item"><a class="propr__item-inner" href="#"
                                            style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/img7.jpg')"><span
                                class="propr__item-bottom"><span>Дача</span><img
                                    src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/arrow.svg"
                                    alt=""></span></a></div>
                <div class="propr__item"><a class="propr__item-inner" href="#"
                                            style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/img8.jpg')"><span
                                class="propr__item-bottom"><span>Сад и Огород</span><img
                                    src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/arrow.svg" alt=""></span></a></div>
                <div class="propr__item"><a class="propr__item-inner" href="#"
                                            style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/img9.jpg')"><span
                                class="propr__item-bottom"><span>Детская площадка</span><img
                                    src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/arrow.svg" alt=""></span></a></div>
            </div>
        </div>
    </div>-->
            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "main_page_nabor",
                array(
                    "VIEW_MODE" => "TEXT",
                    "SHOW_PARENT_NAME" => "Y",
                    "IBLOCK_TYPE" => "1c_catalog",
                    "IBLOCK_ID" => "10",
                    "SECTION_ID" => "146",
                    "SECTION_CODE" => "",
                    "SECTION_URL" => "",
                    "COUNT_ELEMENTS" => "Y",
                    "TOP_DEPTH" => "1",
                    "SECTION_FIELDS" => "",
                    "SECTION_USER_FIELDS" => array('UF_*'),
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_NOTES" => "",
                    "CACHE_GROUPS" => "Y"
                )
            ); ?>
    <div class="news">
        <div class="container">
            <div class="title-main">
                <span class="title-h2">Блог</span>
                <a class="title-main-link" href="<?= SITE_DIR ?>blog/"><span>Все новости</span>
                    <svg>
                        <use xlink:href="#arrow"></use>
                    </svg>
                </a><a class="title-main-arrow" href="<?= SITE_DIR ?>blog/">
                    <svg>
                        <use xlink:href="#arrow"></use>
                    </svg>
                </a>
            </div>
            <div class="row">
                <?
                $GLOBALS["arrBlogFilter"] = array("PROPERTY_MAIN_VALUE" => "Да");
                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "blog",
                    array(
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "AJAX_MODE" => "N",
                        "IBLOCK_TYPE" => "content",
                        "IBLOCK_ID" => "2",
                        "NEWS_COUNT" => "4",
                        "SORT_BY1" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "SORT_BY2" => "ID",
                        "SORT_ORDER2" => "ASC",
                        "FILTER_NAME" => "arrBlogFilter",
                        "FIELD_CODE" => array("ID", "DATE_CREATE"),
                        "PROPERTY_CODE" => array("DESCRIPTION"),
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "SET_TITLE" => "N",
                        "SET_BROWSER_TITLE" => "Y",
                        "SET_META_KEYWORDS" => "Y",
                        "SET_META_DESCRIPTION" => "Y",
                        "SET_LAST_MODIFIED" => "Y",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                        "CACHE_FILTER" => "Y",
                        "CACHE_GROUPS" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "PAGER_TITLE" => "Новости",
                        "PAGER_SHOW_ALWAYS" => "Y",
                        "PAGER_TEMPLATE" => "",
                        "PAGER_DESC_NUMBERING" => "Y",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "Y",
                        "PAGER_BASE_LINK_ENABLE" => "Y",
                        "SET_STATUS_404" => "Y",
                        "SHOW_404" => "N",
                        "MESSAGE_404" => "",
                        "PAGER_BASE_LINK" => "",
                        "PAGER_PARAMS_NAME" => "arrPager",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_ADDITIONAL" => ""
                    )
                );
                unset($GLOBALS["arrBlogFilter"]);
                ?>
            </div>
        </div>
    </div>
    <div class="ab" id="ab">
        <div class="container">
            <div class="ab__inner">
                <div class="ab__text">
                    <div class="ab__text-title">Почему мастера выбирают крепежные изделия из нержавеющей стали</div>
                    <div class="ab__text-tt">Нержавеющий крепеж по праву считается премиальным по сравнению с оцинкованным и черным металлом
                    </div>
                </div>
                <div class="ab__list">
                    <div class="ab__list-item"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/icon6.svg" alt="">
                        <div class="ab__list-item-title">Долговечный</div>
                        <div class="ab__list-item-tx">Прослужит годы</div>
                    </div>
                    <div class="ab__list-item"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/icon7.svg" alt="">
                        <div class="ab__list-item-title">Гигиеничный</div>
                        <div class="ab__list-item-tx">Допустимо в пищевом и медицинском применении
                        </div>
                    </div>
                    <div class="ab__list-item"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/icon8.svg" alt="">
                        <div class="ab__list-item-title">Эстетичный</div>
                        <div class="ab__list-item-tx">Благородный серебристый оттенок металла</div>
                    </div>
                    <div class="ab__list-item"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/icon9.svg" alt="">
                        <div class="ab__list-item-title">Антикоррозийный</div>
                        <div class="ab__list-item-tx">Не боится дождя, снега и ветра
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="base">
        <div class="container">
            <div class="title-main">
                <span class="title-h2">База знаний</span>
                <a class="title-main-link"
                                       href="<?= SITE_DIR ?>knowledge-base/"><span>Все материалы</span>
                    <svg>
                        <use xlink:href="#arrow"></use>
                    </svg>
                </a><a class="title-main-arrow" href="<?= SITE_DIR ?>knowledge-base/">
                    <svg>
                        <use xlink:href="#arrow"></use>
                    </svg>
                </a>
            </div>
            <?
            $GLOBALS["arrBaseFilter"] = array("PROPERTY_MAIN_VALUE" => "Да");
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "base_main",
                array(
                    "DISPLAY_DATE" => "Y",
                    "TAGS_HIGHLOAD_ID" => "2",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "AJAX_MODE" => "N",
                    "IBLOCK_TYPE" => "content",
                    "IBLOCK_ID" => "3",
                    "NEWS_COUNT" => "6",
                    "SORT_BY1" => "SORT",
                    "SORT_ORDER1" => "ASC",
                    "SORT_BY2" => "ID",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "arrBaseFilter",
                    "FIELD_CODE" => array("ID"),
                    "PROPERTY_CODE" => array("DESCRIPTION"),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_LAST_MODIFIED" => "Y",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Новости",
                    "PAGER_SHOW_ALWAYS" => "Y",
                    "PAGER_TEMPLATE" => "",
                    "PAGER_DESC_NUMBERING" => "Y",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "Y",
                    "PAGER_BASE_LINK_ENABLE" => "Y",
                    "SET_STATUS_404" => "Y",
                    "SHOW_404" => "N",
                    "MESSAGE_404" => "",
                    "PAGER_BASE_LINK" => "",
                    "PAGER_PARAMS_NAME" => "arrPager",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => ""
                )
            );
            unset($GLOBALS["arrBaseFilter"]);
            ?>
        </div>
    </div>
    <div class="text">
        <div class="container">
            <div class="text__inner">
                <div class="text__tx" data-more-text="main">
                    <?=$GLOBALS['SEO_TEXT_HTML']?>
                    <span class="button button-more button-primary" data-more-text="btn">
                        <span class="button__name" data-more-text="btn-name">Показать еще</span>
                        <svg>
                            <use xlink:href="#arrow"></use>
                        </svg>
                    </span>
                </div>
                <div class="text__list">
                    <div class="text__list-item">Специализация на нержавеющей стали</div>
                    <div class="text__list-item">Продуманные решения: Крепеж + Такелаж</div>
                    <div class="text__list-item">Быстрая доставка по России</div>
                    <div class="text__list-item">Готовые комплекты и наборы
                    </div>
                    <div class="text__list-item">Удобная и функциональная упаковка </div>
                    <div class="text__list-item">Интуитивная навигация по видам и размерам изделий</div>
                </div>
            </div>
        </div>
    </div>
<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');