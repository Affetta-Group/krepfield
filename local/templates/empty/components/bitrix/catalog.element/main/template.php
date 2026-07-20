<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => array(
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
        'JS_OFFERS' => $arResult['JS_OFFERS']
    )
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId . '_dsc_pict',
    'STICKER_ID' => $mainId . '_sticker',
    'BIG_SLIDER_ID' => $mainId . '_big_slider',
    'BIG_IMG_CONT_ID' => $mainId . '_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId . '_slider_cont',
    'OLD_PRICE_ID' => $mainId . '_old_price',
    'PRICE_ID' => $mainId . '_price',
    'DESCRIPTION_ID' => $mainId . '_description',
    'DISCOUNT_PRICE_ID' => $mainId . '_price_discount',
    'PRICE_TOTAL' => $mainId . '_price_total',
    'SLIDER_CONT_OF_ID' => $mainId . '_slider_cont_',
    'QUANTITY_ID' => $mainId . '_quantity',
    'QUANTITY_DOWN_ID' => $mainId . '_quant_down',
    'QUANTITY_UP_ID' => $mainId . '_quant_up',
    'QUANTITY_MEASURE' => $mainId . '_quant_measure',
    'QUANTITY_LIMIT' => $mainId . '_quant_limit',
    'BUY_LINK' => $mainId . '_buy_link',
    'ADD_BASKET_LINK' => $mainId . '_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId . '_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId . '_not_avail',
    'COMPARE_LINK' => $mainId . '_compare_link',
    'TREE_ID' => $mainId . '_skudiv',
    'DISPLAY_PROP_DIV' => $mainId . '_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId . '_main_sku_prop',
    'OFFER_GROUP' => $mainId . '_set_group_',
    'BASKET_PROP_DIV' => $mainId . '_basket_prop',
    'SUBSCRIBE_LINK' => $mainId . '_subscribe',
    'TABS_ID' => $mainId . '_tabs',
    'TAB_CONTAINERS_ID' => $mainId . '_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId . '_small_card_panel',
    'TABS_PANEL_ID' => $mainId . '_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);

$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers) {
    $actualItem = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] ?? reset($arResult['OFFERS']);
    $showSliderControls = false;

    foreach ($arResult['OFFERS'] as $offer) {
        if ($offer['MORE_PHOTO_COUNT'] > 1) {
            $showSliderControls = true;
            break;
        }
    }
} else {
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

if ($arParams['SHOW_SKU_DESCRIPTION'] === 'Y') {
    $skuDescription = false;
    foreach ($arResult['OFFERS'] as $offer) {
        if ($offer['DETAIL_TEXT'] != '' || $offer['PREVIEW_TEXT'] != '') {
            $skuDescription = true;
            break;
        }
    }
    $showDescription = $skuDescription || !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
} else {
    $showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}

$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])) {
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos) {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION'])) {
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos) {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}

?>

    <div class="cart-product">
        <div class="container">
            <div class="cart-product__inner">
                <div class="cart-product__about" itemscope itemtype="http://schema.org/Product">
                    <div style="display:none" itemprop="name"><?= $arResult['H1'] ?></div>

                    <? include('includes/slider.php'); ?>

                    <? include('includes/some_props.php'); ?>


                    <? include('includes/basket_options.php'); ?>
                </div>

                <? include('includes/bottom_block.php'); ?>

                <?php if ($USER->IsAdmin()):
                    $arFilter = array('IBLOCK_ID' => $arResult["ORIGINAL_PARAMETERS"]["IBLOCK_ID"], 'ID' => $arResult["IBLOCK_SECTION_ID"]);
                    $db_list = CIBlockSection::GetList(array("SORT" => "ASC"), $arFilter, true, ["UF_BANNER", "UF_BANNER_LINK"]);
                    if ($ar_result = $db_list->GetNext()) {
                        $banner = CFile::ResizeImageGet($ar_result['~UF_BANNER'], array('width' => 1200, 'height' => 800))["src"];
                        $link = $ar_result['~UF_BANNER_LINK'];
                    }
                    if ($banner && $link):
                        ?>
                        <div class="banner-container">
                            <a href="<?= $link ?>">
                                <img src="<?= $banner ?>" alt="">
                            </a>
                        </div>
                    <?php elseif ($banner): ?>
                        <div class="banner-container">
                            <img src="<?= $banner ?>" alt="">
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <? include('includes/product_lists.php'); ?>
            </div>
        </div>
    </div>

<? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/advantage.php", array(), array("SHOW_BORDER" => false)); ?>

<?php
$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
$jsParams = array(
    'CONFIG' => array(
        'USE_CATALOG' => $arResult['CATALOG'],
        'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
        'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
        'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
        'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
        'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
        'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
        'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
        'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
        'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
        'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
        'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
        'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
        'USE_STICKERS' => true,
        'USE_SUBSCRIBE' => $showSubscribe,
        'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
        'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
        'ALT' => $alt,
        'TITLE' => $title,
        'MAGNIFIER_ZOOM_PERCENT' => 200,
        'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
        'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
        'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
            ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
            : null
    ),
    'VISUAL' => $itemIds,
    'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
    'PRODUCT' => array(
        'ID' => $arResult['ID'],
        'ACTIVE' => $arResult['ACTIVE'],
        'PICT' => reset($arResult['MORE_PHOTO']),
        'NAME' => $arResult['~NAME'],
        'SUBSCRIPTION' => true,
        'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
        'ITEM_PRICES' => $arResult['ITEM_PRICES'],
        'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
        'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
        'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
        'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
        'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
        'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
        'SLIDER' => $arResult['MORE_PHOTO'],
        'CAN_BUY' => $arResult['CAN_BUY'],
        'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
        'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
        'MAX_QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
        'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
        'CATEGORY' => $arResult['CATEGORY_PATH']
    ),
    'BASKET' => array(
        'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
        'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
        'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
        'EMPTY_PROPS' => $emptyProductProperties,
        'BASKET_URL' => $arParams['BASKET_URL'],
        'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
        'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
    )
);
unset($emptyProductProperties);

if ($arParams['DISPLAY_COMPARE']) {
    $jsParams['COMPARE'] = array(
        'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
        'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
        'COMPARE_PATH' => $arParams['COMPARE_PATH']
    );
}

$jsParams["IS_FACEBOOK_CONVERSION_CUSTOMIZE_PRODUCT_EVENT_ENABLED"] =
    $arResult["IS_FACEBOOK_CONVERSION_CUSTOMIZE_PRODUCT_EVENT_ENABLED"];
?>
    <script type="application/javascript">
        $(".filter-add").click(function () {
            let mat = $(".mat option:selected").text();
            let dia = $(".dia option:selected").text();
            let len = $(".len option:selected").text();
            let mat_mob = $(".mat-mob option:selected").text();
            let dia_mob = $(".dia-mob option:selected").text();
            let len_mob = $(".len-mob option:selected").text();
            let blocks = document.querySelectorAll(".other_products");
            let blocks_mob = document.querySelectorAll(".filter_products");

            for (let i of document.querySelectorAll('#tb .other_products')) {
                i.style.display = 'table-row';
                document.querySelector('#show_more-mob').style.display = 'none';
            }
            for (let i = 0; i < blocks.length; i++) {
                if ((dia !== blocks[i].dataset.diametr && dia !== 'Диаметр' && dia !== '') || (mat !== blocks[i].dataset.material && mat !== 'Материал' && mat !== '')
                    || (len !== blocks[i].dataset.length && len !== 'Длина' && len !== '')) {
                    blocks[i].style.display = "none";
                } else {
                    blocks[i].style.display = "table-row";
                }
                if ((dia_mob !== blocks_mob[i].dataset.diametr && dia_mob !== 'Диаметр' && dia_mob !== '') || (mat_mob !== blocks_mob[i].dataset.material && mat_mob !== 'Материал' && mat_mob !== '')
                    || (len_mob !== blocks_mob[i].dataset.length && len_mob !== 'Длина' && len_mob !== '')) {
                    blocks_mob[i].style.display = "none";
                } else {
                    blocks_mob[i].style.display = "block";
                }
            }
        });
        $(".clear-filter").click(function () {
            $('.js-select').prop('selectedIndex', 0).selectric('refresh');
            let blocks = document.querySelectorAll(".other_products");
            let blocks_mob = document.querySelectorAll(".filter_products");
            for (let i = 0; i <= 5; i++) {
                blocks_mob[i].style.display = "block";
            }
            for (let i = 6; i < blocks_mob.length; i++) {
                blocks_mob[i].style.display = "none";
            }
            for (let i = 0; i < blocks.length; i++) {
                blocks[i].style.display = "table-row";
            }
            document.querySelector('#show_more-mob').style.display = 'block';
        });
        document.querySelectorAll('.cart-product__about-inf-fav').forEach(t => {
                t.addEventListener('click', e => {
                    const item = e.target.closest('.cart-product__about-inf-fav')
                    const item_id = '<?= $arResult['ID'] ?>'
                    let favorites = []
                    if (BX.getCookie('favorites')) {
                        favorites = JSON.parse(BX.getCookie('favorites'))
                    }

                    const item_index = favorites.indexOf(item_id)
                    if (item_index === -1) {
                        ym(90913671, 'reachGoal', 'uzbrannoe')
                        favorites.unshift(item_id)
                        item.classList.toggle("active");
                    } else {
                        favorites.splice(item_index, 1)
                        item.classList.toggle("active");
                    }

                    if (item.classList.contains('active')) {
                        item.querySelector('span').innerHTML = 'В избранном'
                    } else if (!item.classList.contains('active')) {
                        item.querySelector('span').innerHTML = 'В избранное'
                    }
                    BX.setCookie('favorites', JSON.stringify(favorites), {expires: 3600 * 24 * 30, path: `/`})
                })
            }
        );

        BX.message({
            ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
            TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
            TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
            BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
            BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
            BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
            BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
            BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
            TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
            COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
            COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
            COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
            BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
            PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
            PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
            RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
            RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
            SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
        });

        //var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
    </script>
<?php
unset($actualItem, $itemIds, $jsParams);


