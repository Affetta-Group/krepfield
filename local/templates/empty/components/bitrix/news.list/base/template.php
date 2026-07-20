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
<div class="blog-slider-sl js-blog-slider">
	<? foreach ($arResult["ITEMS"] as $arItem): ?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="blog-slider-sl-inner">
			<div class="base__item" style="background-image: url('<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>')"><a
						href="<?= $arItem["DETAIL_PAGE_URL"] ?>"></a>
				<div class="base__item-tag"><?= $arItem["PROPERTIES"]["TAGS"]["VALUE"]["0"] ?></div>
				<div class="base__item-bottom">
					<div class="base__item-title"><?= $arItem["NAME"] ?></div>
					<div class="base__item-img">
						<? if (empty($arItem["PROPERTIES"]["VIDEO"]["VALUE"])): ?>
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/article.svg" alt="">
						<? else: ?>
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/play.svg" alt="">
						<? endif; ?>
					</div>
				</div>
			</div>
		</div>
	<? endforeach; ?>
</div>