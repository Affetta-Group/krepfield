<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */
?>

<?

$sectionComplect = [
    783,
    1098,
    1105,
    1109,
    1113,
    1117,
    1121,
    1100,
    1102,
    1104,
    1160,
    1161,
    1112,
    1162,
    1163,
    1115,
    1164,
    1165,
    1119,
    1167,
    1170,
    1124,
    1168,
    1467,
    1171,
    1468,
    1340,
    1420
];

// if ($GLOBALS["USER"]->IsAdmin()) {
//     echo '<pre>';
//     print_r($item['IBLOCK_SECTION_ID']);
//     echo '</pre>';
// }

?>
<div class="<?=$APPLICATION->GetCurDir() == '/' ? '' : 'col-xl-3'?> col-lg-4 col-md-6 <?=$arParams['CLASS_NAME']?> item-content" data-diametr="<?= $item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_DIAMETR"]["VALUE"] ?>"
     data-length="<?= $item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_DLINA"]["VALUE"] ?>"
     data-material="<?= $item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_MATERIAL"]["VALUE"] ?>" itemscope itemtype="http://schema.org/Product">
     <meta itemprop="productID" content="<?=$item['DISPLAY_PROPERTIES']['CML2_ARTICLE']['VALUE']?>">
    <div class="catalog__item" data-entity="item"
         data-id="<?= $actualItem['ID'] ?>">
        <div class="catalog__item-fav">
            <svg>
                <use xlink:href="#like"></use>
            </svg>
        </div>
        <a class="catalog__item-img" href="<?= $item['DETAIL_PAGE_URL'] ?>">
            <img itemprop="image" src="<?= !empty($item['PREVIEW_PICTURE']) ? $item['PREVIEW_PICTURE']['src'] : SITE_TEMPLATE_PATH . '/assets/images/svg/no-img.svg' ?>"
                 alt="<?= $item['NAME'] ?>" title="<?= $item['NAME'] ?> в интернет-магазине Krepfield">
        </a>
        <a class="catalog__item-title" title="<?= !empty($item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_NAIMENOVANIE"]["VALUE"]) ? $item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_NAIMENOVANIE"]["VALUE"] : $item['NAME'] ?>"
           href="<?= $item['DETAIL_PAGE_URL'] ?>"> <span itemprop="Name"><?= !empty($item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_NAIMENOVANIE"]["VALUE"]) ? $item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_NAIMENOVANIE"]["VALUE"] : $item['NAME'] ?></span></a>
        <div class="catalog__item-line"></div>
       <!-- <?/* if (!empty($item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_KRATNOST_UPAKOVKI"]["VALUE"])): */?>
            <div class="catalog__item-tx">Кол-во в
                упаковке: <?php /*= $item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_KRATNOST_UPAKOVKI"]["VALUE"] */?></div>
        --><?/* endif; */?>

        <? if (in_array($item['IBLOCK_SECTION_ID'], $sectionComplect)):?>
            <div class="catalog__item-tx">Длина: <?= $item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_DLINA"]["VALUE"] ?> м</div>
        <?endif;?>
        <div class="catalog__item-bottom" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <div class="catalog__item-price">
                <div class="catalog__item-price-old" <?= ($price['RATIO_PRICE'] >= $price['RATIO_BASE_PRICE'] ? 'style="display: none;"' : '') ?>><?= $price['PRINT_RATIO_BASE_PRICE'] ?></div>
                <div class="catalog__item-price-now"><?= $price['PRINT_RATIO_PRICE'] ?></div>
                <meta itemprop="price" content="<?= str_replace("&nbsp;", "", $price['PRINT_RATIO_PRICE']) ?>">
                <meta itemprop="priceCurrency" content="RUB">
            </div>
<!--            <?/* if (!empty($item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_KRATNOST_UPAKOVKI"]["VALUE"])): */?>
                <div class="catalog__item-nb">за 1 уп</div>
            --><?/* endif; */?>
            <a class="catalog__item-cart add-basket <?= empty($price['PRINT_RATIO_PRICE']) || $price['PRINT_RATIO_PRICE'] === 0 || !$actualItem['CAN_BUY'] ? 'basket-disabled' : '' ?>"
               data-id="<?= $actualItem['ID'] ?>" href="javascript:void(0);"><img
                        src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/cart2.svg"
                        alt=""></a>
        </div>
    </div>
</div>
