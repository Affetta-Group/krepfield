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
<?php if (!empty($arResult['SECTIONS']) || !empty($arResult['ITEMS'])): ?>
	<div class="masters-position">
		<div class="container">
			<div class="title-main">
				<h2>Выберите вашу специализацию</h2><a class="title-main-arrow" href="#">
					<svg>
						<use xlink:href="#arrow"></use>
					</svg>
				</a>
			</div>
			<div class="masters-position__inner">
				<div class="propr__inner">
					<div class="propr__item propr__item-all mob">
						<div class="propr__item-inner">
							<div class="propr__item-tt">У нас есть<br> крепежные решения <br>для каждого</div>
						</div>
					</div>
					<div class="propr__slider js-propr-slider">
						<div class="propr__slider-item">
							<div class="propr__item propr__item-all">
								<div class="propr__item-inner">
									<div class="propr__item-tt">У нас есть<br> крепежные решения <br>для каждого</div>
								</div>
							</div>
						</div>
						<? foreach ($arResult['SECTIONS'] as $arSection):
							?>
							<div class="propr__slider-item">
								<div class="propr__item">
									<a class="propr__item-inner" href="<?= $arSection["SECTION_PAGE_URL"] ?>"
									   style="background-image: url('<?= $arSection["PICTURE"]["SRC"] ?>')">
					<span class="propr__item-bottom">
						<span><?= $arSection["NAME"] ?></span>
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/arrow.svg" alt="">
					</span>
									</a>
								</div>
							</div>
						<?php
						endforeach; ?>
						<? foreach ($arResult['ITEMS'] as $arItem):
							?>
							<div class="propr__slider-item">
								<div class="propr__item">
									<a class="propr__item-inner" href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
									   style="background-image: url('<?= CFile::GetPath($arItem["PREVIEW_PICTURE"]) ?>')">
					<span class="propr__item-bottom">
						<span><?= $arItem["NAME"] ?></span>
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/arrow.svg" alt="">
					</span>
									</a>
								</div>
							</div>
						<?php
						endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
