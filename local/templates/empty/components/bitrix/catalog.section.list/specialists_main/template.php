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

foreach ($arResult['SECTIONS'] as $arSection):
	?>
	<div class="propr__item">
		<a class="propr__item-inner" href="<?= $arSection["SECTION_PAGE_URL"] ?>"
		   style="background-image: url('<?= $arSection["PICTURE"]["SRC"] ?>')">
			<span class="propr__item-bottom"><span><?= $arSection["NAME"] ?></span>
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/arrow.svg" alt="">
			</span>
		</a>
	</div>
<?php
endforeach;
