<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 */

if (!empty($arResult)): ?>
    <div class="orders__right">
        <div class="orders__pages">
            <?php foreach ($arResult as $i => $arItem):
                if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) {
                    continue;
                } ?>
                <a class="orders__pages-item <?= $arItem['SELECTED']  ? 'active' : '' ?>"
                   href="<?= $arItem["LINK"] ?>">
                    <?= $arItem["TEXT"] ?>
                    <svg>
                        <use xlink:href="<?= $arItem["PARAMS"]["SVG"] ?>"></use>
                    </svg>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>