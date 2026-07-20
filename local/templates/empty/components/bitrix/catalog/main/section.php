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

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);

if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
    $arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

$isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
$isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
$isFilter = ($arParams['USE_FILTER'] == 'Y');
if (empty($arResult["SECTION"]["UF_NABOR"])) {
    $tempItem = 'catalog';
    $isFilterTemp = ($arResult["SECTION"]["DEPTH_LEVEL"] === '3');
} else {
    $tempItem = 'nabor';
}

if ($isFilter) {
    $arFilter = array(
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ACTIVE" => "Y",
        "GLOBAL_ACTIVE" => "Y",
    );
    if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
        $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
    elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
        $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

    $obCache = new CPHPCache();
    if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")) {
        $arCurSection = $obCache->GetVars();
    } elseif ($obCache->StartDataCache()) {
        $arCurSection = array();
        if (Loader::includeModule("iblock")) {
            $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

            if (defined("BX_COMP_MANAGED_CACHE")) {
                global $CACHE_MANAGER;
                $CACHE_MANAGER->StartTagCache("/iblock/catalog");

                if ($arCurSection = $dbRes->Fetch())
                    $CACHE_MANAGER->RegisterTag("iblock_id_" . $arParams["IBLOCK_ID"]);

                $CACHE_MANAGER->EndTagCache();
            } else {
                if (!$arCurSection = $dbRes->Fetch())
                    $arCurSection = array();
            }
        }
        $obCache->EndDataCache($arCurSection);
    }
    if (!isset($arCurSection))
        $arCurSection = array();
}

$dbCurSection = CIBlockSection::GetList(
        array(),
    array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arResult['SECTION']['ID']),
    false,
    array('NAME', 'IBLOCK_SECTION_ID')
)->GetNext();

$ipropValuesCur = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"], $arResult['SECTION']['ID']);
$ipropValuesCur = $ipropValuesCur->getValues();
$ipropValuesParent = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"], $dbCurSection['IBLOCK_SECTION_ID']);
$ipropValuesParent = $ipropValuesParent->getValues();

if ($ipropValuesCur['SECTION_META_TITLE'] !== $ipropValuesParent['SECTION_META_TITLE']) {
    $arResult['IPROPERTY_VALUES'] = $ipropValuesCur;
}

if (!empty($arResult['IPROPERTY_VALUES'])) {
    $APPLICATION->SetTitle($arResult['IPROPERTY_VALUES']['SECTION_META_TITLE']);
    $APPLICATION->SetPageProperty('description', $arResult['IPROPERTY_VALUES']['SECTION_META_DESCRIPTION']);
} else {
    $APPLICATION->SetTitle($arResult['SECTION']['NAME']);
    $APPLICATION->SetPageProperty('description', $arResult['SECTION']['NAME']);
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
            <h1><?= $GLOBALS['UF_H1'] ?? $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'] ?? $arResult["SECTION"]["NAME"] ?></h1>
        </div>
    </div>
</div>
<?

if ($isFilterTemp)
    include($_SERVER["DOCUMENT_ROOT"] . "/" . $this->GetFolder() . "/section_parent.php");
else
    include($_SERVER["DOCUMENT_ROOT"] . "/" . $this->GetFolder() . "/section_child.php");
?>
<script type="application/javascript">
    'use strict';
    $('.catalog-page__content-col-row-it').click(function () {
        let cur_count = $('.catalog-page__content-col-nb').text();
        $('.catalog-page__content-col-nb').html($(this).text() + " <svg><use xlink:href='#arrow2'></use></svg>");
        BX.setCookie('countProducts', $(this).text(), {expires: 3600 * 24 * 30, path: `/`})
        $(this).text(cur_count);
        $('.catalog-page__content-col').removeClass('open');
        let arr = [];
        $('.catalog-page__content-col-row-it').each((function( index ) {
            arr.push($(this).text());
        }))
        BX.setCookie('othercountProducts', arr, {expires: 3600 * 24 * 30, path: `/`})
        window.location.reload();
    });
</script>
<?php
if(isset($_REQUEST['PAGEN_1']) && $_REQUEST['PAGEN_1']>1){
    if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443){ // Получаем протокол домена.
        $protocol = 'https://';
    }else{
        $protocol = 'http://';
    }

    $url = $protocol.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; // Заносим в переменную полный URL текущей страницы.

    $urlend = strrpos($url, '?', -1); // Находим и удаляем все параметры (номер страницы, параметры фильтра и тд.)
    if($urlend != false){
        $url = substr($url, 0, $urlend);
    }

    if(mb_substr($url, -1) == '/'){ // Тут оставляем, если ссылки на сайте не заканчиваются на /, либо удаляем, если заканчиваются на /.
        $url = substr($url, 0, -1);
    }

    $APPLICATION->AddHeadString('<link rel="canonical" href="'.$url.'" />',true); // Добавляем в head тег <link> с атрибутом rel='canonical'.

    // Если необходимо, добавляем в title браузера, номер текущей страницы.
    $title = $APPLICATION->GetPageProperty("title");
    if($title == ''){
        $title = $APPLICATION->GetTitle();
    }

    $APPLICATION->SetPageProperty("title", $title.' | Страница '.$_REQUEST["PAGEN_1"]);
}
?>