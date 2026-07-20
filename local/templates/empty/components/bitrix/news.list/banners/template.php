<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
<div class="banner__slider js-banner-slider">
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <div class="banner__slider-item">
            <div class="banner__slider-inner">
                <div class="banner__slider-text">
                    <div class="banner__slider-title"><?= $arItem["NAME"] ?></div>
                    <? if ($arItem["PROPERTIES"]["LINK_BTN"]["VALUE"]) { ?>
                        <a class="button button-black button-min"
                           href="<?= $arItem["PROPERTIES"]["LINK_BTN"]["VALUE"] ?>">
                            подробнее<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/arrow.svg" alt=''></a>
                    <? } ?>
                    <div class="banner__slider-tx"> <?= $arItem["PREVIEW_TEXT"] ?></div>
                </div>
                <?php if ($arItem["PROPERTIES"]["BG_IMG"]["VALUE"]) {
                    $bgImg = CFile::GetPath($arItem["PROPERTIES"]["BG_IMG"]["VALUE"]);
                    ?>
                    <div class="banner__slider-img"
                         style="background-image: url(' <?= CFile::ResizeImageGet( $arItem["PREVIEW_PICTURE"]["ID"], ["width" => 660, "height" => 400], false,false,false,false)['src'] ?>')">
                         <!-- style="background-image: url(' 
                          <?/*= AffettaCFile::ResizeImageGet( $arItem["PREVIEW_PICTURE"]["ID"], ["width" => 660, "height" => 400], false,false,false,false,['FILE_NAME_NEW' => $arItem["NAME"]])['src'] */?>
                          ')"> -->
                    </div>
                    <style>
                        .banner__slider-img:before {
                            background-image: url("<?=$bgImg?>");
                        }
                    </style>
                <? } else { ?>
                    <div class="banner__slider-img"
                         style="background-image: url(' <?= CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], ["width" => 660, "height" => 400], false,false,false,false)['src'] ?>')">
                         <!-- style="background-image: url(' 
                          <?/*= AffettaCFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], ["width" => 660, "height" => 400], false,false,false,false,['FILE_NAME_NEW' => $arItem["NAME"]])['src'] */?>')"> -->

                    </div>
                    <style>
                        .banner__slider-img:before {
                            background-image: url("");
                        }
                    </style>
                <? } ?>
            </div>
        </div>
    <? endforeach; ?>
</div>