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
<div class="base-top">
	<div class="base-top-text">Подборки мастер-классов и статей от специалистов своего дела</div>
	<div class="base-top-tags">
		<? foreach ($arResult["TAGS"] as $tag): ?>
			<a class="base-top-tags-item" data-tag="<?= $tag["UF_XML_ID"] ?>"
			   href="<?= SITE_DIR ?>knowledge-base/"><?= $tag["UF_NAME"] ?></a>
		<? endforeach; ?>
	</div>
</div>
<div class="base__list">
	<div class="row">
		<? foreach ($arResult["ITEMS"] as $arItem): ?>
			<div class="col-lg-4 col-md-6">
				<div class="base__item"
					 style="background-image: url('<?= CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], ["width" => 450, "height" => 320],false,false,false,false)['src'] ?>')">
					 <!-- style="background-image: url('<?/*= AffettaCFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], ["width" => 450, "height" => 320],false,false,false,false,['FILE_NAME_NEW' => $arItem["NAME"]])['src'] */?>')"> -->

					<a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"></a>
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
<script type="application/javascript">
	'use strict'
	$(() => {
		$('a[data-tag]').click((e) => {
			BX.setCookie('tags', e.currentTarget.dataset.tag, {
				expires: 3600 * 24,
				path: '/'
			});
			location.reload();
		});
	})
</script>