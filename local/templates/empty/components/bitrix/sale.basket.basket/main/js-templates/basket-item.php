<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST'], true) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST'], true);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST'], true);

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
    'left' => 'basket-item-label-left',
    'center' => 'basket-item-label-center',
    'right' => 'basket-item-label-right',
    'bottom' => 'basket-item-label-bottom',
    'middle' => 'basket-item-label-middle',
    'top' => 'basket-item-label-top'
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
?>
<script id="basket-item-template" type="text/html">
    {{^SHOW_RESTORE}}
    <div class="catalog__item" id="basket-item-{{ID}}" data-entity="basket-item"
         data-id="{{ID}}">
        <a class="catalog__item-img" href="{{DETAIL_PAGE_URL}}"><img src="{{{IMAGE_URL}}}" alt=""></a>
        <a class="catalog__item-title" href="{{DETAIL_PAGE_URL}}">{{NAME}}</a>


        {{#CAN_CHANGE_COUNT}}
        <div class="catalog__item-amount" data-entity="basket-item-quantity-block">
            <input type="text" data-entity="basket-item-quantity-field"
                   id="basket-item-quantity-{{ID}}" value="{{QUANTITY}}"
                   data-value="{{QUANTITY}}" max="{{AVAILABLE_QUANTITY}}">
            <span class="up" data-entity="basket-item-quantity-plus"></span>
            <span class="down" data-entity="basket-item-quantity-minus"></span>
        </div>
        {{/CAN_CHANGE_COUNT}}
        {{^CAN_CHANGE_COUNT}}
        <div class="catalog__item-amount" data-entity="basket-item-quantity-block">
            <input type="text" value="{{QUANTITY}}">
        </div>
        {{/CAN_CHANGE_COUNT}}


        <div class="catalog__item-price">
            <div class="catalog__item-price-now" id="basket-item-sum-price-{{ID}}">{{SUM_PRICE_FORMATED}}</div>
        {{#SHOW_DISCOUNT_PRICE}}
            <div class="catalog__item-price-old" id="basket-item-sum-price-old-{{ID}}">{{SUM_FULL_PRICE_FORMATED}}</div>
        {{/SHOW_DISCOUNT_PRICE}}
        </div>
        <div class="catalog__item-close"  data-entity="basket-item-delete"><svg><use xlink:href="#close"></use></svg></div>
    </div>
    {{/SHOW_RESTORE}}
</script>