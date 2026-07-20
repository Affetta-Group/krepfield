<!--	SIDEBAR BLOCK	-->
<div id="bx-soa-total" class="cart-order__total">
    <div class="bx-soa-cart-total-ghost"></div>
    <div class="bx-soa-cart-total cart-order__total-inner"></div>
    <? if (!empty($GLOBALS["MIN_SUM_ORDER"])): ?>
        <div class="cart-order__total-min">Минимальная сумма заказа – <?= $GLOBALS["MIN_SUM_ORDER"] ?>
            ₽
        </div>
    <? endif; ?>
</div>