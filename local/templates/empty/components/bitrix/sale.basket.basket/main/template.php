<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Security\Sign\Signer;
use Bitrix\Main\UI\Extension;
use  Bitrix\Main\Grid\Declension;

Extension::load("ui.fonts.ruble");

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @var string $templateName
 * @var CMain $APPLICATION
 * @var CBitrixBasketComponent $component
 * @var CBitrixComponentTemplate $this
 * @var array $giftParameters
 */

if (!isset($arParams['DISPLAY_MODE']) || !in_array($arParams['DISPLAY_MODE'], array('extended', 'compact'))) {
    $arParams['DISPLAY_MODE'] = 'extended';
}

$arParams['USE_DYNAMIC_SCROLL'] = isset($arParams['USE_DYNAMIC_SCROLL']) && $arParams['USE_DYNAMIC_SCROLL'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_FILTER'] = isset($arParams['SHOW_FILTER']) && $arParams['SHOW_FILTER'] === 'N' ? 'N' : 'Y';

$arParams['PRICE_DISPLAY_MODE'] = isset($arParams['PRICE_DISPLAY_MODE']) && $arParams['PRICE_DISPLAY_MODE'] === 'N' ? 'N' : 'Y';

if (!isset($arParams['TOTAL_BLOCK_DISPLAY']) || !is_array($arParams['TOTAL_BLOCK_DISPLAY'])) {
    $arParams['TOTAL_BLOCK_DISPLAY'] = array('top');
}

$arParams['USE_PRICE_ANIMATION'] = isset($arParams['USE_PRICE_ANIMATION']) && $arParams['USE_PRICE_ANIMATION'] === 'N' ? 'N' : 'Y';
$arParams['EMPTY_BASKET_HINT_PATH'] = isset($arParams['EMPTY_BASKET_HINT_PATH']) ? (string)$arParams['EMPTY_BASKET_HINT_PATH'] : '/';
$arParams['USE_ENHANCED_ECOMMERCE'] = isset($arParams['USE_ENHANCED_ECOMMERCE']) && $arParams['USE_ENHANCED_ECOMMERCE'] === 'Y' ? 'Y' : 'N';
$arParams['DATA_LAYER_NAME'] = isset($arParams['DATA_LAYER_NAME']) ? trim($arParams['DATA_LAYER_NAME']) : 'dataLayer';
$arParams['BRAND_PROPERTY'] = isset($arParams['BRAND_PROPERTY']) ? trim($arParams['BRAND_PROPERTY']) : '';

CJSCore::Init(array('fx', 'popup', 'ajax'));

$this->addExternalJs($templateFolder . '/js/mustache.js');
$this->addExternalJs($templateFolder . '/js/action-pool.js');
$this->addExternalJs($templateFolder . '/js/filter.js');
$this->addExternalJs($templateFolder . '/js/component.js');

$mobileColumns = $arParams['COLUMNS_LIST_MOBILE'] ?? $arParams['COLUMNS_LIST'];
$mobileColumns = array_fill_keys($mobileColumns, true);

$jsTemplates = new Main\IO\Directory(Main\Application::getDocumentRoot() . $templateFolder . '/js-templates');
/** @var Main\IO\File $jsTemplate */
foreach ($jsTemplates->getChildren() as $jsTemplate) {
    include($jsTemplate->getPath());
}

if ($arParams['USE_GIFTS'] === 'Y') {
    $arParams['GIFTS_BLOCK_TITLE'] = isset($arParams['GIFTS_BLOCK_TITLE']) ? trim((string)$arParams['GIFTS_BLOCK_TITLE']) : Loc::getMessage('SBB_GIFTS_BLOCK_TITLE');

    CBitrixComponent::includeComponentClass('bitrix:sale.products.gift.basket');

    $giftParameters = array(
        'SHOW_PRICE_COUNT' => 1,
        'PRODUCT_SUBSCRIPTION' => 'N',
        'PRODUCT_ID_VARIABLE' => 'id',
        'USE_PRODUCT_QUANTITY' => 'N',
        'ACTION_VARIABLE' => 'actionGift',
        'ADD_PROPERTIES_TO_BASKET' => 'Y',
        'PARTIAL_PRODUCT_PROPERTIES' => 'Y',

        'BASKET_URL' => $APPLICATION->GetCurPage(),
        'APPLIED_DISCOUNT_LIST' => $arResult['APPLIED_DISCOUNT_LIST'],
        'FULL_DISCOUNT_LIST' => $arResult['FULL_DISCOUNT_LIST'],

        'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
        'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_SHOW_VALUE'],
        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],

        'BLOCK_TITLE' => $arParams['GIFTS_BLOCK_TITLE'],
        'HIDE_BLOCK_TITLE' => $arParams['GIFTS_HIDE_BLOCK_TITLE'],
        'TEXT_LABEL_GIFT' => $arParams['GIFTS_TEXT_LABEL_GIFT'],

        'DETAIL_URL' => isset($arParams['GIFTS_DETAIL_URL']) ? $arParams['GIFTS_DETAIL_URL'] : null,
        'PRODUCT_QUANTITY_VARIABLE' => $arParams['GIFTS_PRODUCT_QUANTITY_VARIABLE'],
        'PRODUCT_PROPS_VARIABLE' => $arParams['GIFTS_PRODUCT_PROPS_VARIABLE'],
        'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
        'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
        'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
        'MESS_BTN_BUY' => $arParams['GIFTS_MESS_BTN_BUY'],
        'MESS_BTN_DETAIL' => $arParams['GIFTS_MESS_BTN_DETAIL'],
        'CONVERT_CURRENCY' => $arParams['GIFTS_CONVERT_CURRENCY'],
        'HIDE_NOT_AVAILABLE' => $arParams['GIFTS_HIDE_NOT_AVAILABLE'],

        'PRODUCT_ROW_VARIANTS' => '',
        'PAGE_ELEMENT_COUNT' => 0,
        'DEFERRED_PRODUCT_ROW_VARIANTS' => \Bitrix\Main\Web\Json::encode(
            SaleProductsGiftBasketComponent::predictRowVariants(
                $arParams['GIFTS_PAGE_ELEMENT_COUNT'],
                $arParams['GIFTS_PAGE_ELEMENT_COUNT']
            )
        ),
        'DEFERRED_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],

        'ADD_TO_BASKET_ACTION' => 'BUY',
        'PRODUCT_DISPLAY_MODE' => 'Y',
        'PRODUCT_BLOCKS_ORDER' => isset($arParams['GIFTS_PRODUCT_BLOCKS_ORDER']) ? $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'] : '',
        'SHOW_SLIDER' => isset($arParams['GIFTS_SHOW_SLIDER']) ? $arParams['GIFTS_SHOW_SLIDER'] : '',
        'SLIDER_INTERVAL' => isset($arParams['GIFTS_SLIDER_INTERVAL']) ? $arParams['GIFTS_SLIDER_INTERVAL'] : '',
        'SLIDER_PROGRESS' => isset($arParams['GIFTS_SLIDER_PROGRESS']) ? $arParams['GIFTS_SLIDER_PROGRESS'] : '',
        'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],

        'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
        'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
        'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
    );
}

$displayModeClass = $arParams['DISPLAY_MODE'] === 'compact' ? ' basket-items-list-wrapper-compact' : '';

if (empty($arResult['ERROR_MESSAGE'])) {
    include_once "includes/basket_items.php";
} elseif ($arResult['EMPTY_BASKET']) {
    include(Main\Application::getDocumentRoot() . $templateFolder . '/empty.php');
} else {
    ShowError($arResult['ERROR_MESSAGE']);
}?>

<script>
    $('#btnPrint').on('click', (e) => {
        e.preventDefault()
        window.print()
    })
</script>
