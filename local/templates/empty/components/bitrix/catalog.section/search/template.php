<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 *
 *  _________________________________________________________________________
 * |    Attention!
 * |    The following comments are for system use
 * |    and are required for the component to work correctly in ajax mode:
 * |    <!-- items-container -->
 * |    <!-- pagination-container -->
 * |    <!-- component-end -->
 */

$this->setFrameMode(true);
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');

/*if (!empty($arResult['NAV_RESULT'])) {
    $navParams = array(
        'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
        'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
        'NavNum' => $arResult['NAV_RESULT']->NavNum
    );
} else {
    $navParams = array(
        'NavPageCount' => 1,
        'NavPageNomer' => 1,
        'NavNum' => $this->randString()
    );
}

$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;*/

if (true || $arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1) {
    $showTopPager = $arParams['DISPLAY_TOP_PAGER'];
    $showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
    $showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'];
}

$templateLibrary = array('popup', 'ajax', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])) {
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos) {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION'])) {
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos) {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}

$arParams['~MESS_BTN_BUY'] = $arParams['~MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_BUY');
$arParams['~MESS_BTN_DETAIL'] = $arParams['~MESS_BTN_DETAIL'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_DETAIL');
$arParams['~MESS_BTN_COMPARE'] = $arParams['~MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_COMPARE');
$arParams['~MESS_BTN_SUBSCRIBE'] = $arParams['~MESS_BTN_SUBSCRIBE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE');
$arParams['~MESS_BTN_ADD_TO_BASKET'] = $arParams['~MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET');
$arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE');
$arParams['~MESS_SHOW_MAX_QUANTITY'] = $arParams['~MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCS_CATALOG_SHOW_MAX_QUANTITY');
$arParams['~MESS_RELATIVE_QUANTITY_MANY'] = $arParams['~MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['~MESS_RELATIVE_QUANTITY_FEW'] = $arParams['~MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_FEW');

$arParams['MESS_BTN_LAZY_LOAD'] = $arParams['MESS_BTN_LAZY_LOAD'] ?: Loc::getMessage('CT_BCS_CATALOG_MESS_BTN_LAZY_LOAD');

$generalParams = array(
    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
    'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
    'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
    'MESS_SHOW_MAX_QUANTITY' => $arParams['~MESS_SHOW_MAX_QUANTITY'],
    'MESS_RELATIVE_QUANTITY_MANY' => $arParams['~MESS_RELATIVE_QUANTITY_MANY'],
    'MESS_RELATIVE_QUANTITY_FEW' => $arParams['~MESS_RELATIVE_QUANTITY_FEW'],
    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
    'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
    'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
    'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
    'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
    'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
    'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'],
    'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
    'COMPARE_PATH' => $arParams['COMPARE_PATH'],
    'COMPARE_NAME' => $arParams['COMPARE_NAME'],
    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
    'PRODUCT_BLOCKS_ORDER' => $arParams['PRODUCT_BLOCKS_ORDER'],
    'LABEL_POSITION_CLASS' => $labelPositionClass,
    'DISCOUNT_POSITION_CLASS' => $discountPositionClass,
    'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
    'SLIDER_PROGRESS' => $arParams['SLIDER_PROGRESS'],
    '~BASKET_URL' => $arParams['~BASKET_URL'],
    '~ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
    '~BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE'],
    '~COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
    '~COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
    'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
    'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY'],
    'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
    'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
    'MESS_BTN_COMPARE' => $arParams['~MESS_BTN_COMPARE'],
    'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
    'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
    'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE']
);

$obName = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($navParams['NavNum']));
$containerName = 'container-' . $navParams['NavNum'];
$count_prod = $arResult['NAV_RESULT']->NavRecordCount;

if ($showTopPager) {
    ?>
    <div data-pagination-num="<?= $navParams['NavNum'] ?>">
        <!-- pagination-container -->
        <?php if (!empty($arParams['NAV_STRING'])) { ?>
            <?= $arParams['~NAV_STRING'] ?>
        <?php } else {  ?>
            <?= $arResult['NAV_STRING']; ?>
        <?php } ?>
        <!-- pagination-container -->
    </div>
    <?
}
?>
<?php
$areaIds = array();

foreach ($arResult['ITEMS'] as $item) {
    $uniqueId = $item['ID'] . '_' . md5($this->randString() . $component->getAction());
    $areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
    $this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
    $this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
}
// TODO переделать алгоритм
$flag = 0;
$flag_tab = 0;
$flag_tab_nabor = 0;
?>
<!--<ul class="nav nav-tabs" id="myTab2" role="tablist">-->
<!--    --><?// foreach ($arResult['ITEMS_BY_GROUP']['SECTIONS'] as $i => $SECTION): ?>
<!--        --><?// if (empty($SECTION["UF_TAB"])):
//        if ($flag_tab === 0):
//            $flag_tab = 1;
//            ?>
<!--            <li class="nav-item" role="presentation">-->
<!--                <button class="nav-link active" id="tb11-tab" data-bs-toggle="tab" data-bs-target="#tb11"-->
<!--                        type="button" role="tab" aria-controls="tb11" aria-selected="true">Товары-->
<!--                </button>-->
<!--            </li>-->
<!--            --><?//endif;?>
<!--        --><?//else:?>
<!--        --><?//$flag_tab_nabor =1;?>
<!--            <li class="nav-item" role="presentation">-->
<!--                <button class="nav-link --><?php //=$flag_tab === 0 ? 'active': ''?><!--" id="tb2--><?php //= $i ?><!---tab" data-bs-toggle="tab"-->
<!--                        data-bs-target="#tb2--><?php //= $i ?><!--"-->
<!--                        type="button" role="tab" aria-controls="tb2--><?php //= $i ?><!--" aria-selected="false">-->
<!--                    --><?php //= $SECTION["NAME"] ?>
<!--                </button>-->
<!--            </li>-->
<!--        --><?// endif; ?>
<!--    --><?// endforeach; ?>
<!--</ul>-->
<div class="tab-content" id="myTabContent2">
    
    <!-- items-container -->
    <?php /*
    <? foreach ($arResult['ITEMS_BY_GROUP']['SECTIONS'] as $i => $SECTION): ?>
        <? if (!empty($SECTION["UF_TAB"])): ?>
            <div class="tab-pane fade <?=$flag_tab === 0 ? ' show active': ''?>" id="tb2<?= $i ?>" role="tabpanel"
                 aria-labelledby="tb2<?= $i ?>-tab">
                <div class="catalog-page__content-tb">
                    <div class="row items-list">
                        <? foreach ($arResult['ITEMS_BY_GROUP'][$SECTION['ID']] as $j => $item) {
                            $arItem = $arResult['ITEMS'][$item];
                            $APPLICATION->IncludeComponent(
                                'bitrix:catalog.item',
                                'nabor',
                                array(
                                    'RESULT' => array(
                                        'ITEM' => $arItem,
                                        'AREA_ID' => $areaIds[$arItem['ID']],
                                        'TYPE' => 'CARD',
                                        'BIG_LABEL' => 'N',
                                        'BIG_DISCOUNT_PERCENT' => 'N',
                                        'BIG_BUTTONS' => 'N'
                                    ),
                                    'PARAMS' => $generalParams
                                        + array('SKU_PROPS' => $arResult['SKU_PROPS'][$arItem['IBLOCK_ID']])
                                        + array('IS_FAVORITE' => in_array($arItem['ID'], $GLOBALS['FAVORITES']) ? 'Y' : 'N')
                                ),
                                $component,
                                array('HIDE_ICONS' => 'Y')
                            );
                        }
                        ?>
                    </div>
                </div>
            </div>
        <? else: ?>
            <? if ($flag === 0 && $flag_tab === 1): ?>
                <div class="tab-pane fade show active" id="tb11" role="tabpanel"
                aria-labelledby="tb11-tab">
                <div class="catalog-page__content-tb">
                <div class="row items-list">
                <? $flag = 1; ?>
            <? endif; ?>
            <? foreach ($arResult['ITEMS_BY_GROUP'][$SECTION['ID']] as $j => $item) {
                $arItem = $arResult['ITEMS'][$item];
                echo $arItem['ID'];
                $APPLICATION->IncludeComponent(
                    'bitrix:catalog.item',
                    'catalog',
                    array(
                        'RESULT' => array(
                            'ITEM' => $arItem,
                            'AREA_ID' => $areaIds[$arItem['ID']],
                            'TYPE' => 'CARD',
                            'BIG_LABEL' => 'N',
                            'BIG_DISCOUNT_PERCENT' => 'N',
                            'BIG_BUTTONS' => 'N'
                        ),
                        'PARAMS' => $generalParams
                            + array('SKU_PROPS' => $arResult['SKU_PROPS'][$arItem['IBLOCK_ID']])
                            + array('IS_FAVORITE' => in_array($arItem['ID'], $GLOBALS['FAVORITES']) ? 'Y' : 'N')
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
            }
            ?>
            <? if ($flag === 1 && $flag_tab === 1 && (($flag_tab_nabor === 1 && array_key_last($arResult['ITEMS_BY_GROUP']['SECTIONS'])-1 === $i) || ($flag_tab_nabor === 0 && array_key_last($arResult['ITEMS_BY_GROUP']['SECTIONS']) === $i))): ?>
                </div>
                </div>
                </div>
            <? endif; ?>
        <? endif; ?>
    <? endforeach; ?>*/ ?>

    <div class="tab-pane fade show active" id="tb11" role="tabpanel" aria-labelledby="tb11-tab">
        
        <div class="catalog-page__content-tb">
            
            <div class="row items-list">
                
                <? foreach ($arResult['ITEMS'] as $arItem) {
                    $APPLICATION->IncludeComponent(
                        'bitrix:catalog.item',
                        'catalog',
                        array(
                            'RESULT' => array(
                                'ITEM' => $arItem,
                                'AREA_ID' => $areaIds[$arItem['ID']],
                                'TYPE' => 'CARD',
                                'BIG_LABEL' => 'N',
                                'BIG_DISCOUNT_PERCENT' => 'N',
                                'BIG_BUTTONS' => 'N'
                            ),
                            'PARAMS' => $generalParams
                                + array('SKU_PROPS' => $arResult['SKU_PROPS'][$arItem['IBLOCK_ID']])
                                + array('IS_FAVORITE' => in_array($arItem['ID'], $GLOBALS['FAVORITES']) ? 'Y' : 'N')
                        ),
                        $component,
                        array('HIDE_ICONS' => 'Y')
                    );
                }
                ?>
            </div>
        </div>
    </div>
    <!-- items-container -->
</div>
<?

if ($showBottomPager) {
    ?>
    <!-- pagination-container -->
    <?php if (!empty($arParams['NAV_STRING'])) { ?>
        <?= $arParams['~NAV_STRING'] ?>
    <?php } else {  ?>
        <?= $arResult['NAV_STRING']; ?>
    <?php } ?>
    <!-- pagination-container -->
    <?
}
?>
<?php
$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'catalog.section');
$signedParams = $signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');
?>
<!-- component-end -->