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
<div class="catalog__item <?= $arParams['IS_FAVORITE'] === 'Y' ? 'catalog__item-fav-on' : '' ?>"
    data-entity="item" data-id="<?= $actualItem['ID'] ?>">
    <div class="catalog__item-fav">
        <svg>
            <use xlink:href="#like"></use>
        </svg>
    </div>
    <a class="catalog__item-img" href="<?= $item['DETAIL_PAGE_URL'] ?>">
        <img src="<?= !empty($item['PREVIEW_PICTURE']) ? $item['PREVIEW_PICTURE']['src'] : SITE_TEMPLATE_PATH . '/assets/images/svg/no-img.svg' ?>"
             alt="<?= $item['NAME'] ?>" title="<?= $item['NAME'] ?> в интернет-магазине Krepfield">
    <a class="catalog__item-title" title="<?= !empty($item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_NAIMENOVANIE"]["VALUE"]) ? $item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_NAIMENOVANIE"]["VALUE"] : $item['NAME'] ?>"
       href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= !empty($item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_NAIMENOVANIE"]["VALUE"]) ? $item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_NAIMENOVANIE"]["VALUE"] : $item['NAME'] ?></a>
    <div class="catalog__item-line"></div>
   <!-- <?/* if (!empty($item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_KRATNOST_UPAKOVKI"]["VALUE"])): */?>
        <div class="catalog__item-tx">Кол-во в
            упаковке: <?php /*= $item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_KRATNOST_UPAKOVKI"]["VALUE"] */?></div>
    --><?/* endif; */?>
    <div class="catalog__item-bottom">
        <div class="catalog__item-price">
            <div class="catalog__item-price-old" <?= ($price['RATIO_PRICE'] >= $price['RATIO_BASE_PRICE'] ? 'style="display: none;"' : '') ?>><?= $price['PRINT_RATIO_BASE_PRICE'] ?></div>
            <div class="catalog__item-price-now"><?= $price['PRINT_RATIO_PRICE'] ?></div>
        </div>        
<!--        <?/* if (!empty($item["DISPLAY_PROPERTIES"]["KF_DLYA_SAYTA_KRATNOST_UPAKOVKI"]["VALUE"])): */?>
            <div class="catalog__item-nb">за 1 уп</div>
        --><?/* endif; */?>
        <a class="catalog__item-cart add-basket <?= empty($price['PRINT_RATIO_PRICE']) || $price['PRINT_RATIO_PRICE'] === 0 || !$actualItem['CAN_BUY'] ? 'basket-disabled' : '' ?>"
           data-id="<?= $actualItem['ID'] ?>" href="javascript:void(0);"><img
                    src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/cart2.svg"
                    alt=""></a>
    </div>
</div>
