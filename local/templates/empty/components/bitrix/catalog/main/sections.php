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

$this->setFrameMode(true); ?>
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
            <h1><?= !empty($arParams['TITLE']) ? $arParams['TITLE'] : 'Каталог' ?></h1>
        </div>
    </div>
</div>
<div class="catalog-page">
    <div class="container">
        <div class="catalog-page__inner th">
            <div class="catalog-page__content">
                <div class="catalog-main">
                    <?
                    $APPLICATION->IncludeComponent(
                        "custom:catalog.section.list",
                        "catalog_main",
                        array(
                            "VIEW_MODE" => "TEXT",
                            "SHOW_PARENT_NAME" => "Y",
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "SECTION_ID" => "",
                            "SECTION_CODE" => "",
                            "SECTION_URL" => "",
                            "COUNT_ELEMENTS" => "Y",
                            "TOP_DEPTH" => "3",
                            "SECTION_FIELDS" => array("SECTION_PAGE_URL", "PICTURE", "LEFT_MARGIN", "RIGHT_MARGIN"),
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
        </div>
    </div>
</div>
<div class="text th">
    <div class="container">
        <div class="text__inner">
            <div class="text__tx">
                <h2>О компании KREPFIELD</h2>
                <p>Компания KREPFIELD специализируется на продукции из нержавеющих сталей, предлагая крепежные и такелажные решения для профессиональных строителей и домашних мастеров.  </p>
                <p>На складе имеется полный ассортимент нержавеющего крепежа, такелажа, оснастки, а также готовых крепежно-такелажных решений. </p><a class="button button-primary" href="<?= SITE_DIR ?>about/">подробнее
                    <svg>
                        <use xlink:href="#arrow"></use>
                    </svg>
                </a>
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

<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/advantage.php", Array(), Array("SHOW_BORDER"=>false));?>