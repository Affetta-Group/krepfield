<div class="cart-product__about-slider">
    <div class="cart-product__about-slider-for">
        <? if (!empty($arResult["DETAIL_PICTURE"]["src"])): ?>
            <div class="cart-product__about-slider-for-item"><a
                    class="cart-product__about-slider-for-inner"
                    href="<?= $arResult["DETAIL_PICTURE"]["src"] ?>"
                    data-fancybox>
                    <img itemprop="image" src="<?= $arResult["DETAIL_PICTURE"]["src"] ?>"
                         alt="<?= $arResult['DETAIL_PICTURE']['ALT'] ?>"
                         title="<?= $arResult['DETAIL_PICTURE']['TITLE'] ?>">
                </a>
            </div>
        <? endif; ?>

        <?php if (!empty($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])): ?>
            <?php foreach ($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $value): ?>
                <div class="cart-product__about-slider-for-item"><a
                        class="cart-product__about-slider-for-inner" href="<?= $value['src'] ?>"
                        data-fancybox>
                        <img src="<?= $value['src'] ?>"
                             alt="<?= $value['ALT'] ?>"
                             title="<?= $value['TITLE'] ?>">
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <div class="cart-product__about-slider-nav">
        <? if (!empty($arResult["DETAIL_PICTURE"]["src"]) && !empty($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) && count($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) > 0): ?>
            <div class="cart-product__about-slider-nav-item">
                <div class="cart-product__about-slider-nav-inner">
                    <img src="<?= $arResult["DETAIL_PICTURE"]["src"] ?>"
                         alt="<?= $arResult['DETAIL_PICTURE']['ALT'] ?>"
                         title="<?= $arResult['DETAIL_PICTURE']['TITLE'] ?>">
                </div>
            </div>
        <? endif; ?>

        <?php if (!empty($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])): ?>
            <?php foreach ($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $value): ?>
                <div class="cart-product__about-slider-nav-item">
                    <div class="cart-product__about-slider-nav-inner">
                        <img src="<?= $value['src'] ?>"
                             alt="<?= $value['ALT'] ?>"
                             title="<?= $value['TITLE'] ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>