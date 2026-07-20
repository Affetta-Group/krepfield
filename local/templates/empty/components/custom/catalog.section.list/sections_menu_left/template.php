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
?>
<?php if (!empty($arResult['SECTIONS'])): ?>
    <div class="filter__title-t-inner <?= $arParams['SHOW_MORE'] == 'N' ? 'on' : '' ?>">
        <? foreach ($arResult['SECTIONS'] as $arSection): ?>
            <a class="filter__title-m" href="<?= $arSection["SECTION_PAGE_URL"] ?>"><?= $arSection["NAME"] ?></a>
        <? endforeach; ?>
        <? if (count($arResult['SECTIONS']) > 5 && $arParams['SHOW_MORE'] !== 'N'): ?>
            <style>
                .filter__title-m:nth-of-type(5) {
                    display: none;
                }
            </style>
            <div class="filter__title-t-btn">Еще</div>
        <? endif; ?>
    </div>
<?php endif; ?>
