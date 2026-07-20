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
<div class="row items-list">
	<? foreach ($arResult["ITEMS"] as $arItem): ?>
    <? if ($arItem['PROPERTIES']['ONLY_ADMINS']['VALUE'] == 'Да' && !$USER->IsAdmin()) continue;?>
		<div class="col-xl-3 col-lg-4 col-md-6 item-content">
			<div class="news__item conf"><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"></a>
				<div class="news__item-title"><?= $arItem["NAME"] ?></div>
				<div class="news__item-tx"><?= $arItem["PREVIEW_TEXT"] ?>
				</div>
				<div class="news__item-bottom">
					<? if (!empty($arItem["DATE"])): ?>
						<div class="news__item-data"></div>
					<? endif; ?>
				</div>
			</div>
		</div>
	<? endforeach; ?>
</div>
<div class="catalog-page__content-tb-bottom">
	<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
		<?= $arResult["NAV_STRING"] ?>
	<? endif; ?>
</div>
