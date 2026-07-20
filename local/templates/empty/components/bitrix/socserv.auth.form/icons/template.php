<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>

<? foreach ($arParams["~AUTH_SERVICES"] as $service): ?>
<? if (htmlspecialcharsbx($service["NAME"]) == 'ВКонтакте'): ?>
    <a title="<?= htmlspecialcharsbx($service["NAME"]) ?>" href="javascript:void(0)"
       class="enter__item-link"
       onclick="BxShowAuthFloat('<?= $service["ID"] ?>', '<?= $arParams["SUFFIX"] ?>')">
        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/en3.svg"
             alt=''> С помощью ВКонтакте</a>
    <?else:?>
    <a title="<?= htmlspecialcharsbx($service["NAME"]) ?>" href="javascript:void(0)"
       class="enter__item-link"
       onclick="BxShowAuthFloat('<?= $service["ID"] ?>', '<?= $arParams["SUFFIX"] ?>')">
        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/yandex.svg"
             alt=''> С помощью Яндекса</a>
<?endif;?>
<? endforeach ?>