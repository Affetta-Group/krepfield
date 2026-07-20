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
    <div class="catalog-page__content-filter js-filter-mob">Фильтр</div>
    <? foreach ($arResult['SECTIONS'] as $arSection): ?>
        <?php if ($arSection["DEPTH_LEVEL"] === "3"): ?>
            <div class="catalog-main__item">
                <a class="catalog-main__item-inner" href="<?= $arSection["SECTION_PAGE_URL"] ?>">
                <span class="catalog-main__item-img">
                    <img src="<?= $arSection["PICTURE"]["SRC"] ?>" alt="Купить <?=$arSection["NAME"]?> в KREPFIELD" title="<?=$arSection["NAME"]?> в интернет магазине KREPFIELD">
                </span>
                    <span class="catalog-main__item-tx"><?= $arSection["NAME"] ?></span>
                </a>
            </div>
        <?php endif; ?>
    <? endforeach; ?>
<?php endif; ?>
