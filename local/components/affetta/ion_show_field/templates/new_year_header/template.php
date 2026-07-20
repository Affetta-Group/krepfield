<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @var array $arResult
 */
if($GLOBALS['ion']['UF_NEW_YEAR_HEADER'] == "Y"){
?>
    <?php if($APPLICATION->GetCurDir() === '/'): ?>
        <div class="header__logo">
            <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/NY_logo.svg" alt="Купить нержавеющий крепеж в KREPFIELD" title="Нержавеющие крепежные изделия KREPFIELD">
        </div>
    <?php else: ?>
        <a class="header__logo" href="<?= SITE_DIR ?>">
            <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/NY_logo.svg" alt="Купить нержавеющий крепеж в KREPFIELD" title="Нержавеющие крепежные изделия KREPFIELD">
        </a>
    <?php endif; ?>
<?php
} else {
?>
    <?php if($APPLICATION->GetCurDir() === '/'): ?>
        <div class="header__logo">
            <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/logo.svg" alt="Купить нержавеющий крепеж в KREPFIELD" title="Нержавеющие крепежные изделия KREPFIELD">
        </div>
    <?php else: ?>
        <a class="header__logo" href="<?= SITE_DIR ?>">
            <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/logo.svg" alt="Купить нержавеющий крепеж в KREPFIELD" title="Нержавеющие крепежные изделия KREPFIELD">
        </a>
    <?php endif; ?>
<?php
}