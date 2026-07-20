<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
    <div class="cart-order__total">
        <form action="" method="POST" id="clean-basket">
            <input type="hidden" name="BasketClear">
            <div class="cart-order__total-ct-close"
                 onclick="document.getElementById('clean-basket').submit(); return false;">
                Очистить корзину
                <svg>
                    <use xlink:href="#close"></use>
                </svg>
            </div>
        </form>
        <div class="cart-order__total-inner">
            <div class="cart-order__total-ct">
                <?php if ($arParams['HIDE_COUPON'] !== 'Y'): ?>
                    <div class="cart-order__total-ct-form">
                        <input type="text" data-entity="basket-coupon-input"
                               placeholder="Введите код купона для скидки">
                        <span class="basket-coupon-block-coupon-btn" style="display: none;"></span>
                        <button class="button button-bord" type="submit">Применить</button>
                    </div>
                    {{#COUPON_LIST}}
                    <div class="basket-coupon-alert text-{{CLASS}}">
                        <div class="promo-check {{CLASS}}"> промокод
                            <strong>&nbsp;{{COUPON}}&nbsp;</strong> {{JS_CHECK_CODE}}
                        </div>
                        <a class="promo-check-del" data-entity="basket-coupon-delete" data-coupon="{{COUPON}}">
                            Удалить промокод
                        </a>
                    </div>
                    {{/COUPON_LIST}}
                <?php endif; ?>
                <div class="cart-order__total-ct-all">
                    <div>Итого:</div>
                    <div>
                        <span data-entity="basket-total-price">{{{PRICE_FORMATED}}}</span>
                    </div>
                </div>
                <p class="basket-promo__tax">НДС 22% включен в цену</p>
                <? if (CModule::IncludeModule("affettapromo"))
                    $userPromo = Bitrix\Affettapromo\Utils::getUserPromoStatus();
                    if($userPromo){
                        ?>
                        <div id="affetta-promo" class="basket-promo">

                            <label for="aff-promo-recount-basket-items-price" class="basket-promo__checkbox custom-checkbox">
                                <input type="checkbox" name="promo" value="Y" id="aff-promo-recount-basket-items-price"/>
                                Использовать бонусы (<?=$userPromo['UF_PROMO_CASH']?> баллов)
                            </label>
                            <p class="basket-promo__max-bonus">Максимум доступно {{{MAX_BONUS_USE_ABILITY}}} бонусов</p>

                            <div id="affetta-promo__spoiler" class="affetta-promo__spoiler">

                                <div class="basket-promo__bonus-selector">
                                    <input id="aff-promo-recount-basket-items-bonus-count" value="1" type="text">
                                    <div class="basket-promo__bonus-selector-text">
                                        <p>бонусов</p>
                                    </div>
                                </div>

                                <input type="range" id="aff-promo-recount-basket-items-bonus-scroll" name="volume" min="1" value="1" max="{{{MAX_BONUS_USE_ABILITY}}}">
                            </div>
                        </div>
                        <?
                    }
                ?>

                <div class="cart-order__total-ct-btn">
                    <a class="button button-black" data-entity="basket-checkout-button" href="javascript:void(0);">оформить
                        заказ</a>
                </div>
                <div class="cart-order__total-ct-print">
                    <a class="cart-order__print" href="javascript:void(0)" id="btnPrint">
                        <svg>
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/svg.svg#ord1"></use>
                        </svg>
                        Распечатать
                    </a>
                </div>
            </div>
        </div>
    </div>
</script>