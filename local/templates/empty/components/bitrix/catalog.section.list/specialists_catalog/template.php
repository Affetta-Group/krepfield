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
<div class="masters-categor__inner">
    <div class="row">
        <?
        foreach ($arResult['SECTIONS'] as $arSection):
            ?>
            <div class="col-xl-2 col-lg-3 col-md-6">
                <div class="catalog-main__item"><a class="catalog-main__item-inner" href="<?= $arSection["SECTION_PAGE_URL"] ?>">
                        <span class="catalog-main__item-img">
                            <img src="<?=CFile::GetPath($arSection["UF_PIC_SPEC"])?>"
                                    alt="">
                        </span>
                        <span class="catalog-main__item-tx"><?= $arSection["NAME"] ?></span></a></div>
            </div>
        <?php
        endforeach; ?>
    </div>
    <a class="button button-black mob" href="<?= SITE_DIR ?>catalog/">Все товары</a>
</div>
