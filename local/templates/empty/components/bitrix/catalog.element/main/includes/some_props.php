<div class="cart-product__about-list">
    <div class="cart-product__about-list-row">
        <?php if (!empty($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'])): ?>
            <div class="cart-product__about-list-row-item">
                <b>Артикул:</b> <?= $arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'] ?></div>
            <meta itemprop="productID" content="<?= $arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'] ?>">
        <? endif; ?>
        <?php if (!empty($arResult['PROPERTIES']['KF_DLYA_SAYTA_STANDART']['VALUE'])): ?>
            <div class="cart-product__about-list-row-item">
                <b>Стандарт:</b> <?= $arResult['PROPERTIES']['KF_DLYA_SAYTA_STANDART']['VALUE'] ?>
            </div>
        <? endif; ?>
        <?php if (!empty($arResult['PROPERTIES']['KF_DLYA_SAYTA_UPAKOVKA']['VALUE'])): ?>
            <div class="cart-product__about-list-row-item"><b>Тип упаковки:</b> <?= $arResult['PROPERTIES']['KF_DLYA_SAYTA_UPAKOVKA']['VALUE'] ?></div>
        <? endif; ?>
        <?php if (!empty($arResult['PROPERTIES']['KF_DLYA_SAYTA_MATERIAL']['VALUE'])): ?>
            <div class="cart-product__about-list-row-item">
                <b>Материал:</b> <?= $arResult['PROPERTIES']['KF_DLYA_SAYTA_MATERIAL']['VALUE'] ?>
            </div>
        <? endif; ?>
        <a class="cart-product__about-list-row-link js-link" href="#hr">Все характеристики</a>
    </div>
    <? if (!empty($arResult["PRODUCTS_OTHER_SIZE"]["PROPS"])): ?>
        <div class="cart-product__about-list-row">
            <? if (!empty($arResult["PRODUCTS_OTHER_SIZE"])): ?>
                <a class="cart-product__about-list-row-link js-link" href="#hr2">Все размеры</a>
            <? endif; ?>
        </div>
    <? endif; ?>
</div>