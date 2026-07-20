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

$catalog_sections_id = ['88','104','130','137'];
?>
<div class="page-top">
    <div class="container">
        <div class="page-topmasters-categor__inner">
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
            <h1><?= !empty($arParams['TITLE']) ? $arParams['TITLE'] : 'Крепежные изделия для мастеров' ?></h1>
        </div>
    </div>
</div>
<div class="masters-text">
    <div class="container">
        <div class="masters-text__inner">«Крепфилд» — это оптово-розничный магазин, а также один из крупнейших
            и успешно развивающихся интернет-магазинов России, занимающийся продажей крепежа. Мы предоставляем
            широчайший ассортимент такелажа из нержавеющей стали, крепежа из разнообразных материалов.
        </div>
    </div>
</div>
<? $APPLICATION->IncludeComponent(
    "bitrix:catalog.section.list",
    "specialists",
    array(
        "VIEW_MODE" => "TEXT",
        "SHOW_PARENT_NAME" => "Y",
        "IBLOCK_TYPE" => "content",
        "IBLOCK_ID" => "5",
        "SECTION_ID" => "",
        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
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
<div class="masters-categor">
    <div class="container">
        <div class="title-main">
            <h2>Категории товаров для вас</h2>
            <a class="title-main-link" href="<?= SITE_DIR ?>catalog/"><span>Все товары</span>
                <svg>
                    <use xlink:href="#arrow"></use>
                </svg>
            </a>
        </div>
        <?
        $GLOBALS['arrFilter'] = array("ID" => $catalog_sections_id);
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "specialists_catalog",
            array(
                "VIEW_MODE" => "TEXT",
                "SHOW_PARENT_NAME" => "Y",
                "IBLOCK_TYPE" => "1c_catalog",
                "IBLOCK_ID" => "10",
                "SECTION_ID" => "",
                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "SECTION_URL" => "",
                "COUNT_ELEMENTS" => "Y",
                "FILTER_NAME" => 'arrFilter',
                "TOP_DEPTH" => "10",
                "SECTION_FIELDS" => "",
                "SECTION_USER_FIELDS" => array('UF_*'),
                "ADD_SECTIONS_CHAIN" => "Y",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_NOTES" => "",
                "CACHE_GROUPS" => "Y"
            )
        );
        unset($GLOBALS['arrFilter']);
        ?>
    </div>
</div>
<!-- Скрытый блок
<div class="propr">
    <div class="container">
        <div class="title-main">
            <h2>Комплекты для ваших задач</h2><a class="title-main-link" href="#"><span>Все комплекты</span>
                <svg>
                    <use xlink:href="#arrow"></use>
                </svg>
            </a>
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
</div> -->
<div class="masters-form">
    <div class="masters-form-bg">
        <div class="container">
            <div class="masters-form__inner">
                <div class="masters-form__text">
                    <h2>Ждем ваших идей и предложений</h2>
                    <p>Знаете как сделать классные качели или скамейку и хотите этим поделиться? Мы в свою очередь
                        приготовили для вас плюшки, пока не знаем какие, но мы придумаем.</p>
                </div>
                <div class="masters-form__fr">
                    <? $APPLICATION->IncludeComponent(
                        "custom:form",
                        "specialists_ideas",
                        array(
                            'IBLOCK_ID' => '1',
                            'MAIL_EVENT' => 'FORM_SENDED',
                            'ACTIVE' => 'Y',
                            'TOKEN' => 'form03',
                            'FORM_NAME' => 'Форма Ждем ваших идей и предложений',
                            'PROPS' => array(
                                'NAME', // type - string
                                'EMAIL', // type - string
                                'FILE,FILE', // type - file
                                'MES', // type - string
                                'FORM_NAME',
                                'URL',
                            ),
                        )
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="masters-about">
    <div class="container">
        <h2>Предлагаем специальные условия для мастеров</h2>
        <div class="masters-about__inner">
            <div class="row">
                <div class="col-lg-4">
                    <div class="masters-about__item">
                        <div class="masters-about__item-img"><img
                                    src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/f1.svg" alt=""></div>
                        <div class="masters-about__item-title">Весь товар сертифицирован</div>
                        <div class="masters-about__item-tx">Наша компания предоставляет широчайший ассортимент
                            такелажа из оцинкованной и нержавеющей стали, крепежа из разнообразных материалов
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="masters-about__item">
                        <div class="masters-about__item-img"><img
                                    src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/f2.svg" alt=""></div>
                        <div class="masters-about__item-title">Персональный консультант</div>
                        <div class="masters-about__item-tx">Наша компания предоставляет широчайший ассортимент
                            такелажа из оцинкованной и нержавеющей стали, крепежа из разнообразных материалов
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="masters-about__item">
                        <div class="masters-about__item-img"><img
                                    src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/f3.svg" alt=""></div>
                        <div class="masters-about__item-title">Удобная и быстрая доставка</div>
                        <div class="masters-about__item-tx">Наша компания предоставляет широчайший ассортимент
                            такелажа из оцинкованной и нержавеющей стали, крепежа из разнообразных материалов
                        </div>
                    </div>
                </div>
            </div>
            <div class="button-center"><a class="button button-black" href="#form__">
                    узнать условия
                    <svg>
                        <use xlink:href="#arrow" class="icon"></use>
                    </svg>
                </a></div>
        </div>
    </div>
</div>
<div class="base">
    <div class="container">
        <div class="title-main">
            <h2>База знаний</h2><a class="title-main-link"
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
        ?>
    </div>
</div>
<div class="masters-form tw" style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/bg7.jpg')"
     id="form__">
    <div class="container">
        <div class="masters-form__inner">
            <div class="masters-form__text">
                <h2>Узнать индивидуальные условия</h2>
                <p>Заполните небольшую форму, и мы отправим вам прайс лист с самыми свежими ценами на наши
                    качественные и долговечные материалы</p>
            </div>
            <div class="masters-form__fr">
                <? $APPLICATION->IncludeComponent(
                    "custom:form",
                    "conditions",
                    array(
                        'IBLOCK_ID' => '1',
                        'MAIL_EVENT' => 'FORM_SENDED',
                        'ACTIVE' => 'Y',
                        'TOKEN' => 'form04',
                        'FORM_NAME' => 'Форма Узнать индивидуальные условия',
                        'PROPS' => array(
                            'NAME', // type - string
                            'EMAIL', // type - string
                            'PHONE', // type - string
                            'DIRECTION', // type - string
                            'FORM_NAME',
                            'URL',
                        ),
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>

<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/advantage.php", Array(), Array("SHOW_BORDER"=>false));?>
