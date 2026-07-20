<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

?>
<div class="all tw">
    <div class="container">
        <div class="all__inner">
            <div class="all__img"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/b2.png" alt=""></div>
            <div class="all__title">Ваша корзина пуста</div>
            <div class="all__tx">Перейдите в каталог или воспользуйтесь <br>поиском, если ищете что-то конкретное</div>
            <div class="all__btn">
                <a class="button button-black" href="<?= SITE_DIR ?>catalog/">Вернуться в каталог</a>
            </div>
        </div>
    </div>
</div>