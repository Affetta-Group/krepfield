<?php use Bitrix\Main\Localization\Loc; ?>

<div class="cart-product__about-inf" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    <div class="cart-product__about-inf-top">
        <div class="cart-product__about-inf-price">
            <div class="cart-product__about-inf-price-old" <?= ($price['RATIO_PRICE'] >= $price['RATIO_BASE_PRICE'] ? 'style="display: none;"' : '') ?>><?= $price['PRINT_RATIO_BASE_PRICE'] ?></div>
            <div class="cart-product__about-inf-price-now" itemprop="price"><?= str_replace("&nbsp;", "", $price['PRINT_RATIO_PRICE']) ?></div>
            <meta itemprop="priceCurrency" content="RUB">
            <link itemprop="availability" href="http://schema.org/InStock">
        </div>
        <div class="cart-product__about-inf-fav" data-id="<?=$arResult['ID']?>">
            <svg>
                <use xlink:href="#like"></use>
            </svg>
            <span><?= in_array((string)$arResult['ID'], $GLOBALS['FAVORITES'], true) ? 'В избранном' : 'В избранное' ?></span>
        </div>
    </div>
    <div class="cart-product__about-inf-numb">НДС 22% включен в цену</div>

    <div class="cart-product__about-inf-numb" style="margin-bottom: 10px">Есть на складе: <?=$arResult['PRODUCT']['QUANTITY']?> шт.</div>
    <div class="cart-product__about-inf-tx" style="display:none;">
        <div class="cart-product__about-inf-tx-item">Возможна только <b>безналичная оплата</b></div>
        <div class="cart-product__about-inf-tx-item">Доставка по Москве и области в день заказа
        </div>
        <div class="cart-product__about-inf-tx-item"><b>Бесплатная доставка</b> до ТК от 1кг!</div>
    </div>


    <? if ($arParams['USE_PRODUCT_QUANTITY']): ?>
        <div class="product-item-detail-info-container" style="<?=(!$actualItem['CAN_BUY'] ? 'display: none;' : '')?>"
             data-entity="quantity-block">
            <div class="product-item-detail-info-container-title"><?=Loc::getMessage('CATALOG_QUANTITY')?></div>
            <div class="product-item-amount">
                <div class="product-item-amount-field-container">
                    <span class="product-item-amount-field-btn-minus no-select" id="<?=$itemIds['QUANTITY_DOWN_ID']?>"></span>
                    <input class="product-item-amount-field af-qa-basket QUANTITY" id="<?=$itemIds['QUANTITY_ID']?>" type="number"
                           value="<?=$price['MIN_QUANTITY']?>" min="1" max="<?=$arResult['PRODUCT']['QUANTITY']?>">
                    <span class="product-item-amount-field-btn-plus no-select" id="<?=$itemIds['QUANTITY_UP_ID']?>"></span>
                    <span class="product-item-amount-description-container">
                        <span id="<?=$itemIds['QUANTITY_MEASURE']?>">
                            <?=$actualItem['ITEM_MEASURE']['TITLE']?>
                        </span>
                        <span id="<?=$itemIds['PRICE_TOTAL']?>" class="PRICE_TOTAL"></span>
                    </span>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <div class="cart-product__about-inf-btn">
        <?php if ($actualItem['CAN_BUY']): ?>
            <a class="button button-black add-basket" data-id="<?= $arResult['ID'] ?>"
               href="javascript:void(0);">В корзину</a>
            <div class="cart-product__about-inf-packing">К стоимости каждой позиции будет добавлено 60 рублей на фасовку, упаковку и маркировку</div>
        <? else: ?>
            <div class="button button-gray">временно нет в наличии</div>
        <? endif; ?>
        <?php if (!empty($arResult['PROPERTIES']['PDF_FILE']['VALUE'])): ?>
            <a class="cart-product__about-inf-btn-pdf"
               href="<?=CFile::GetPath($arResult['PROPERTIES']['PDF_FILE']['VALUE']);?>">
                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/pdf.svg" alt="">
                <span>PDF–версия товара</span>
            </a>
        <?endif;?>
    </div>
</div>

<script>
    $(document).ready(function(){
       
        $('.af-qa-basket').change(function(){
            if (+$(this).attr('max') < $(this).val()) {
                $(this).val($(this).attr('max'));
            }
            if (+$(this).attr('min') > $(this).val()) {
                $(this).val($(this).attr('min'));
            }
        });
        $('.QUANTITY').change(function(){
            var num = Math.round($(this).val()*$('.cart-product__about-inf-price-now').html()*100)/100;
            $('.PRICE_TOTAL').html(num);
            $('.PRICE_TOTAL').html( $('.PRICE_TOTAL').html()+ " ₽");
        })
    });
</script>