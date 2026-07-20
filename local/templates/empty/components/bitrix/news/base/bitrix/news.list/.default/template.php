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
<?php if (!empty($arResult["ITEMS"])): ?>
	<div class="base__list">
		<div class="row items-list">
			<? foreach ($arResult["ITEMS"] as $arItem): ?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<div class="col-lg-4 col-md-6 item-content">
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
	</div>
	<div class="catalog-page__content-tb-bottom">
		<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
			<?= $arResult["NAV_STRING"] ?>
		<? endif; ?>
	</div>
<?php else: ?>
	<p> Статей с данным тегом не найдено </p>
<?php endif; ?>