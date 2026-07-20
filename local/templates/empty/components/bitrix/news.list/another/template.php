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

if (!empty($arResult["ITEMS"])):
?>
<div class="article__right"><a class="article__nw-title" href="<?= SITE_DIR ?>blog/">Другие статьи</a>
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="news__item"><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"></a>
		<div class="news__item-title"><?= $arItem["NAME"] ?></div>
		<div class="news__item-tx">
			<?= $arItem["PREVIEW_TEXT"] ?>
		</div>
		<div class="news__item-bottom">
			<? if (!empty($arResult["DISPLAY_ACTIVE_FROM"])): ?>
				<div class="news__item-data"><?= $arItem["DATE"] ?></div>
			<? endif; ?>
		</div>
	</div>
<? endforeach; ?>
</div>
<?php endif;