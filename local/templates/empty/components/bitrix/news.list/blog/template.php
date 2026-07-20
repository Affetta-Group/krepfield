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
<? foreach ($arResult["ITEMS"] as $arItem): ?>
	<div class="col-lg-3 col-md-6">
		<div class="news__item"><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"></a>
			<div class="news__item-title"><?= $arItem["NAME"] ?></div>
			<div class="news__item-tx"> <?= $arItem["PREVIEW_TEXT"] ?>
			</div>
			<div class="news__item-bottom">
				<? if (!empty($arItem["DATE"])): ?>
					<div class="news__item-data"><?= $arItem["DATE"] ?></div>
				<? endif; ?>
			</div>
		</div>
	</div>
<? endforeach; ?>
