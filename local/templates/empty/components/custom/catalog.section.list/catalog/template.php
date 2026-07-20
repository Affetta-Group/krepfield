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
<?php if (!empty($arResult['SECTIONS'])): ?>
	<div class="catalog-page__list">
		<? foreach ($arResult['SECTIONS_TREE'] as $arSection): ?>
			<div class="catalog-page__list-item">
				<a class="catalog-page__list-title"
				   href="<?= $arSection["SECTION_PAGE_URL"] ?>">
					<?= $arSection["NAME"] ?>
				</a>
				<?php
				if (!empty($arSection['CHILDS'])): ?>
					<ul>
						<? foreach ($arSection['CHILDS'] as $CHILD): ?>
							<li><a href="<?= $CHILD["SECTION_PAGE_URL"] ?>"><?= $CHILD["NAME"] ?></a></li>
						<? endforeach; ?>
					</ul>
					<? if ($arSection['CHILDS']['COUNT_CHILDS'] > 4): ?>
						<div class="catalog-page__list-btn">Еще</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<? endforeach; ?>
	</div>
<?php endif; ?>
