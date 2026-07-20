<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global array $arParams
 * @global array $arResult
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */

$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] === 'Y');
?>
<svg>
    <use xlink:href="#cart"></use>
</svg>
<span class="header__info-item-title">Корзина</span>
<?php if (!$compositeStub && $arParams['SHOW_NUM_PRODUCTS'] === 'Y'): ?>
        <span class="header__info-item-numb"><?= $arResult['NUM_PRODUCTS'] ?></span>
<?php endif; ?>

<span class="header__info-item-amount"><?= $arResult['TOTAL_PRICE'] ?>&nbsp;</span>
