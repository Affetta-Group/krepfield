<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

use  Bitrix\Main\Grid\Declension;
?>
<div class="catalog-min__inner">
    <?if (!empty($arResult['SECTIONS'])):?>
    <div class="catalog-min__list">
        <ul>
            <? foreach ($arResult['SECTIONS'] as $arSection): ?>
                <li><a href="<?= $arSection["SECTION_PAGE_URL"] ?>"><?= $arSection["NAME"] ?></a></li>
            <? endforeach; ?>
        </ul>
    </div>
    <?endif;?>
    <div class="catalog-min__info <?=$arResult["SECTION"]["UF_COLOR"]?>">
        <div class="catalog-min__info-top">
            <div class="catalog-min__info-top-title"><?= $arResult["SECTION"]["NAME"] ?></div>
            <div class="catalog-min__info-top-nb">
                <span><?= $arResult["SECTION"]["ELEMENT_CNT"] ?></span> <?= (new Declension('товар', 'товара', 'товаров'))->get($arResult["SECTION"]["ELEMENT_CNT"]) ?>
            </div>
            <div class="catalog-min__info-top-icon"><img
                        src="<?= CFile::GetPath($arResult["SECTION"]["UF_PIC_MAIN_SVG"]) ?>" alt=""></div>
        </div>
        <div class="catalog-min__info-img"
            style="background-image: url('<?= CFile::ResizeImageGet($arResult["SECTION"]["UF_PIC_MAIN"], ["width" => 600, "height" => 600],false,false,false,false)['src'] ?>')"></div>
            <!-- style="background-image: url('<?/*= AffettaCFile::ResizeImageGet($arResult["SECTION"]["UF_PIC_MAIN"], ["width" => 600, "height" => 600],false,false,false,false,['FILE_NAME_NEW' => $arResult["SECTION"]["NAME"]])['src'] */?>')"></div> -->

    </div>
    <div class="catalog-min__cats">
        <?
        if ($arParams["FILTER"] === "Y"){
            $GLOBALS["arrFilter"] = array(">CATALOG_PRICE_1" => 0, "PROPERTY_IS_MAIN_VALUE" => "Да");
        } else {
            $GLOBALS["arrFilter"] = array(">CATALOG_PRICE_1" => 0);
        }
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.section",
            "main_page_sections",
            array(
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "IBLOCK_TYPE" =>  $arParams["IBLOCK_TYPE"],
                "FILTER_NAME" => "arrFilter",
                "SECTION_ID" => $arResult["SECTION"]["ID"],
                "HIDE_NOT_AVAILABLE" => "Y",
                "PRICE_CODE" => array(
                    0 => "РРЦ",
                ),
                "ELEMENT_SORT_FIELD" => "sort",
                "ELEMENT_SORT_ORDER" => "desc",
                "INCLUDE_SUBSECTIONS" => "Y",
                "SHOW_ALL_WO_SECTION" => "Y",
                "PAGE_ELEMENT_COUNT" => "6",
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
