<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global array $arParams
 * @global array $arResult
 */

$this->IncludeLangFile('template.php');

$cartId = $arParams['cartId'];

require(realpath(__DIR__) . '/top_template.php');

if ($arParams["SHOW_PRODUCTS"] === "Y" && ($arResult['NUM_PRODUCTS'] > 0 || !empty($arResult['CATEGORIES']['DELAY']))): ?>
    <script>
        BX.ready(() => {
            <?=$cartId?>.fixCart();
        });
    </script>
<?php endif; ?>
