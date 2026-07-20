<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();
?>
<footer class="footer">
    <div class="footer-form">
        <div class="container">
            <div class="footer-form__inner">
                <div class="footer-form__tx">Лучшие предложения <br> у вас на почте</div>
                <div class="footer-form__inp">
                    <input type="email" id="email_mailing" placeholder="Ваш E-mail">
                    <button class="button button-primary" id="sbm_mailing" type="submit">Подписаться</button>
                </div>
                <? if (!empty($GLOBALS["LINK_VK"])): ?>
                    <div class="footer-form__soc">
                        <ul>
                            <li><a href="<?= $GLOBALS["LINK_VK"] ?>" target="_blank">
                                    <svg>
                                        <use xlink:href="#soc1"></use>
                                    </svg>
                                </a></li>
                        </ul>
                        <div class="footer-form__soc-tx">Мы в соцсетях</div>
                    </div>
                <? endif; ?>
            </div>
        </div>
    </div>
    <div class="footer-info">
        <div class="container">
            <div class="footer-info__inner">
                <div class="footer-info__all">
                    <a class="footer-info__logo"
                       href="<?= ($APPLICATION->GetCurDir() == '/' ? 'javascript:void(0)' : SITE_DIR) ?>">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo2.png" alt="Нержавеющий крепеж - купить в интернет-магазине Крепфилд" title="Нержавеющие крепежи, такелаж и метизы Крепфилд">
                    </a>
                    <div class="footer-info__tx">Нержавеющие крепежные решения<br> для профессионалов, ценящих свое
                        время
                    </div>
<!--                    <div class="footer-info__tl">-->
<!--                        <a class="footer-info__tl-link" href="tel:--><?php //= $GLOBALS["PHONE"] ?><!--">--><?php //= $GLOBALS["PHONE"] ?><!--</a>-->
<!--                        <div class="footer-info__tl-t">Бесплатно по России</div>-->
<!--                    </div>-->
                    <div class="footer-info__tl">
                        <div class="footer-info__tl-link-site"><?= $GLOBALS["SERVER_NAME"] ?></div>
                        <a class="footer-info__tl-link"
                           href="tel:<?= $GLOBALS["PHONE_MSK"] ?>"><?= $GLOBALS["PHONE_MSK"] ?></a>
                        <a class="footer-info__tl-link"
                           href="tel:+7 (925) 181-04-38">+7 (925) 181-04-38</a>
                        <a class="footer-info__tl-link"
                           href="mailto:<?= $GLOBALS["EMAIL"] ?>"><?= $GLOBALS["EMAIL"] ?></a>
                            <!-- <a class="footer-info__tl-link"
                           href="mailto:info@krepfield.ru">info@krepfield.ru</a> -->
                        <div class="footer-info__tl-t"><?= htmlspecialcharsback($GLOBALS["ADDRESS"]) ?></div>
                        <div class="footer-info__tl-t">
                            <br><?=$GLOBALS["WORKTIME"]?></div>
                    </div>
                </div>
                <div class="footer-info__menu">
                    <div class="footer-info__menu-row">
                        <div class="footer-info__menu-title">Товары</div>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "footer_catalog",
                            array(
                                "ROOT_MENU_TYPE" => "bottom1",
                                "MAX_LEVEL" => "3",
                                "CHILD_MENU_TYPE" => "bottom1",
                                "USE_EXT" => "Y",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "Y",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_USE_GROUPS" => "N",
                                "MENU_CACHE_GET_VARS" => ""
                            )
                        ); ?>
                    </div>
                    <div class="footer-info__menu-row">
                        <div class="footer-info__menu-title">Покупателям</div>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "header",
                            array(
                                "ROOT_MENU_TYPE" => "bottom2",
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => "bottom2",
                                "USE_EXT" => "Y",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "Y",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_USE_GROUPS" => "N",
                                "MENU_CACHE_GET_VARS" => ""
                            )
                        ); ?>
                    </div>
                </div>
                <div class="footer-inf">
                    <div class="footer-inf-mob">
                        <div class="footer-info__tl">
                            <a class="footer-info__tl-link"
                               href="tel:<?= $GLOBALS["PHONE"] ?>"><?= $GLOBALS["PHONE"] ?></a>
                            <div class="footer-info__tl-t">Бесплатно по России</div>
                        </div>
                        <div class="footer-info__tl">
                            <a class="footer-info__tl-link"
                               href="tel:+7 (925) 181-04-38">+7 (925) 181-04-38</a>
                            <div class="footer-info__tl-t">Дополнительный номер</div>
                        </div>
                        <div class="footer-info__tl">
                            <a class="footer-info__tl-link"
                               href="mailto:<?= $GLOBALS["EMAIL"] ?>"><?= $GLOBALS["EMAIL"] ?></a>
                               
                            <div class="footer-info__tl-t"><?= $GLOBALS["ADDRESS"] ?></div>
                        </div>
                    </div>
                    <div class="footer-inf-pay">
                        <div class="footer-inf-pay-title">Мы принимаем к оплате</div>
                        <ul>
                            <li><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo4.webp" alt="Варианты оплаты в интернет-магазине KREPFIELD" title="Платежные системы принимаемые в KREPFIELD"></li>
                        </ul>
                    </div>
                    <div class="footer-inf-pay-mob">
                        <div class="footer-inf-pay-title">Мы принимаем к оплате</div>
                        <ul>
                            <li><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo4_mob.webp" alt="Варианты оплаты в интернет-магазине KREPFIELD" title="Платежные системы принимаемые в KREPFIELD"></li>
                        </ul>
                    </div>
                    <div class="footer-inf-list">
                        <div class="footer-inf-list-title">Правовая информация</div>
                        <ul>
                            <li><a href="<?= SITE_DIR ?>oferta/">Публичная оферта</a></li>
                            <li><a href="<?= SITE_DIR ?>policy/">Политика конфиденциальности</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom__inner">
                <div class="footer-bottom__tx">© <?= date('Y') ?> «KREPFIELD» – Нержавеющий крепеж, метизы и крепежные
                    изделия
                </div>
                <!-- noindex -->
                    <a class="footer-bottom__link" href="https://affetta.ru/" target="_blank" rel="nofollow">Создание сайта – Affetta</a>
                <!--/ noindex -->
            </div>
        </div>
    </div>
</footer>

<?php
include "includes/modals.php";
?>

<script type="application/javascript">
    $(document).ready(function () {
        $('#sbm_mailing').click(e => {
            e.preventDefault();
            let status = true;
            if ($('#email_mailing').val() === "") {
                $('#email_mailing').css({"border": "1px solid red"})
                status = false
            } else {
                $('#email_mailing').css({"border": "unset"})
            }
            if (status) {
                let formdata = new FormData();
                formdata.append("EMAIL", $("#email_mailing").val());
                $.ajax({
                    url: "/local/ajax/mailing.php",
                    type: 'POST',
                    data: formdata,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        data = JSON.parse(data);
                        if (data.message !== 'success') {
                            $('#modalZvMail .modal-tx-cont-tt').text(data.message);
                        }
                        ym(90913671, 'reachGoal', 'podpiska-na-rassulky')
                        $('#modalZvMail').modal('show').on('hidden.bs.modal', () => {
                            location.reload();
                        });
                    }
                });
            }
        });
    });

    $('.add-basket').click(e => {
        if (!$(this).hasClass("basket-disabled")) {
            e.preventDefault();
            const body = new FormData()
            body.append('PRODUCT_ID', e.currentTarget.dataset.id)
            body.append('QUANTITY', document.querySelector(".af-qa-basket") ? document.querySelector(".af-qa-basket").value : '1')
            fetch("/local/ajax/add2basket_ajax.php", {
                method: 'post',
                body
            })
                .then(response => response.json())
                .then(json => {
                    json.status ? $('#modalCart').modal('show') : $('#exampleModalCartError').modal('show');
                })
                .then(function () {
                    ym(90913671, 'reachGoal', 'dobavlenie-tovara-v-korziny')
                    BX.onCustomEvent('OnBasketChange');
                })

        }
    });

    document.querySelectorAll('div[data-entity="item"] .catalog__item-fav').forEach(t => {
            t.addEventListener('click', e => {
                const item = e.target.closest('div[data-entity="item"]')
                const item_id = item.dataset.id
                let favorites = []
                if (BX.getCookie('favorites')) {
                    favorites = JSON.parse(BX.getCookie('favorites'))
                }

                const item_index = favorites.indexOf(item_id)
                if (item_index === -1) {
                    ym(90913671, 'reachGoal', 'uzbrannoe')
                    favorites.unshift(item_id)
                    item.classList.toggle("catalog__item-fav-on");
                } else {
                    favorites.splice(item_index, 1)
                    item.classList.toggle("catalog__item-fav-on");
                }
                BX.setCookie('favorites', JSON.stringify(favorites), {expires: 3600 * 24 * 30, path: `/`})
            })
        }
    );
</script>
<script src="<?= SITE_TEMPLATE_PATH ?>/vendors/jquery/dist/jquery.min.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/vendors/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/vendors/select/jquery.selectric.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/vendors/fancybox/dist/jquery.fancybox.min.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/vendors/jqueryui-touch-punch/jquery.ui.touch-punch.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/vendors/jquery.maskedinput/dist/jquery.maskedinput.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/vendors/validator.min.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/vendors/imask.min.js"></script>
<script type="text/javascript"
        src="<?= SITE_TEMPLATE_PATH ?>/vendors/jquery.mCustomScrollbar/jquery.mCustomScrollbar.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/vendors/slick/slick.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/app.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/dev.js?v=<?=uniqid()?>"></script>
<?= $GLOBALS['SEO_BODY'] ?>
</body>
</html>
