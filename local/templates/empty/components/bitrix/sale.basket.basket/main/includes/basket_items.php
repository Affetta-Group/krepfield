<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Security\Sign\Signer;
use Bitrix\Main\UI\Extension;
use  Bitrix\Main\Grid\Declension;

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
?>
<div class="cart-order" id="basket-root">
    <div class="container">
        <div class="cart-order__inner">
            <div class="cart-order__left">
                <div class="cart-order__tl" id="basket-item-table">

                </div>
            </div>
            <div class="cart-order__total" data-entity="basket-total-block">

            </div>
        </div>
    </div>
</div>
<?php if (!empty($arResult['CURRENCIES']) && Main\Loader::includeModule('currency')):
    CJSCore::Init('currency'); ?>
    <script>
        BX.Currency.setCurrencies(<?=CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true)?>);
    </script>
<?php endif;

$signer = new Signer;
$signedTemplate = $signer->sign($templateName, 'sale.basket.basket');
$signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.basket.basket');
$messages = Loc::loadLanguageFile(__FILE__);
?>
<script>
    BX.message(<?=CUtil::PhpToJSObject($messages)?>);
    BX.Sale.BasketComponent.init({
        result: <?=CUtil::PhpToJSObject($arResult, false, false, true)?>,
        params: <?=CUtil::PhpToJSObject($arParams)?>,
        template: '<?=CUtil::JSEscape($signedTemplate)?>',
        signedParamsString: '<?=CUtil::JSEscape($signedParams)?>',
        siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
        siteTemplateId: '<?=CUtil::JSEscape($component->getSiteTemplateId())?>',
        templateFolder: '<?=CUtil::JSEscape($templateFolder)?>'
    });
</script>
<?php
if ($arParams['USE_GIFTS'] === 'Y' && $arParams['GIFTS_PLACE'] === 'BOTTOM') {
    ?>
    <div data-entity="parent-container">
        <div class="catalog-block-header"
             data-entity="header"
             data-showed="false"
             style="display: none; opacity: 0;">
            <?= $arParams['GIFTS_BLOCK_TITLE'] ?>
        </div>
<!--        --><?//
//        $APPLICATION->IncludeComponent(
//            'bitrix:sale.products.gift.basket',
//            '.default',
//            $giftParameters,
//            $component
//        );
//        ?>
    </div>
    <?
}