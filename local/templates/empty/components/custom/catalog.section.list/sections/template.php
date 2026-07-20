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
<?php if (!empty($arResult['SECTIONS'])): ?>
    <? foreach ($arResult['SECTIONS'] as $arSection): ?>
        <div class="catalog-main__item">
            <a class="catalog-main__item-inner" href="<?= $arSection["SECTION_PAGE_URL"] ?>">
                <span class="catalog-main__item-img">
                    <img src="<?= $arSection["SVG"] ?>"
                         alt="">
                </span>
                <span class="catalog-main__item-tx"><?= $arSection["NAME"] ?></span>
                <span class="catalog-main__item-nb"><?= $arSection["ELEMENT_CNT"] ?> <?= (new Declension('товар', 'товара', 'товаров'))->get($arSection["ELEMENT_CNT"]) ?></span></a>
        </div>
    <? endforeach; ?>
<?php endif; ?>
