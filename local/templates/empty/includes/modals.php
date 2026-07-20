<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();
?>
<!-- Modal -->
<div class="modal fade" id="ur" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                <svg>
                    <use xlink:href="#close"></use>
                </svg>
            </button>
            <div class="modal-body">
                <div class="modal-call" style="max-width: 610px">
                    <div class="modal-call-title" style="text-align: center">Юридическим лицам</div>
                    <p style="text-align: justify"><?=$UR_MOD?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalCall" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                <svg>
                    <use xlink:href="#close"></use>
                </svg>
            </button>
            <div class="modal-body">
                <div class="modal-call">
                    <div class="modal-call-title">Заказать звонок</div>
                    <? $APPLICATION->IncludeComponent(
                        "custom:form",
                        "modal",
                        array(
                            'IBLOCK_ID' => '1',
                            'MAIL_EVENT' => 'FORM_SENDED',
                            'ACTIVE' => 'Y',
                            'TOKEN' => 'form01',
                            'FORM_NAME' => 'Заказать звонок',
                            'PROPS' => array(
                                'NAME', // type - string
                                'PHONE', // type - string
                                'FORM_NAME',
                                'URL',
                            ),
                            'TELEGRAM_BOT_TOKEN' => $GLOBALS['telegram_bot_token'],
                            'TELEGRAM_CHAT_ID' => $GLOBALS['telegram_chat_id'],
                        )
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalQuestion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                <svg>
                    <use xlink:href="#close"></use>
                </svg>
            </button>
            <div class="modal-body">
                <div class="modal-call">
                    <div class="modal-call-title">Задать вопрос</div>
                    <?
                    $APPLICATION->IncludeComponent(
                        "custom:form",
                        "modalQuestion",
                        array(
                            'IBLOCK_ID' => '1',
                            'MAIL_EVENT' => 'FORM_SENDED',
                            'ACTIVE' => 'Y',
                            'TOKEN' => 'form02',
                            'FORM_NAME' => 'Задать вопрос',
                            'PROPS' => array(
                                'NAME', // type - string
                                'PHONE', // type - string
                                'QUESTION', // type - string
                                'FORM_NAME',
                                'URL',
                            ),
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalZv" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                <svg>
                    <use xlink:href="#close"></use>
                </svg>
            </button>
            <div class="modal-body">
                <div class="modal-tx">
                    <div class="modal-tx-inner">
                        <div class="modal-tx-img"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/modal-img1.svg"
                                                       alt=""></div>
                        <div class="modal-tx-cont">
                            <div class="modal-tx-cont-tt">Ваша заявка успешно отправлена</div>
                            <div class="modal-tx-cont-t">Наш менеджер свяжется с вами для уточнения деталей</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalZvMail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                <svg>
                    <use xlink:href="#close"></use>
                </svg>
            </button>
            <div class="modal-body">
                <div class="modal-tx">
                    <div class="modal-tx-inner">
                        <div class="modal-tx-img"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/modal-img1.svg"
                                                       alt=""></div>
                        <div class="modal-tx-cont">
                            <div class="modal-tx-cont-tt">Вы успешно подписались на рассылку</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalCart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                <svg>
                    <use xlink:href="#close"></use>
                </svg>
            </button>
            <div class="modal-body">
                <div class="modal-tx">
                    <div class="modal-tx-inner">
                        <div class="modal-tx-img">
                            <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/modal-img2.svg"
                                 alt=""></div>
                        <div class="modal-tx-cont">
                            <div class="modal-tx-cont-tt">Товар добавлен в корзину</div>
                            <div class="modal-tx-cont-t">Вы можете продолжить покупки или перейти в корзину</div>
                        </div>
                    </div>
                    <div class="modal-tx-btn">
                        <a class="button button-black" href="<?= SITE_DIR ?>personal/cart/">перейти в корзину</a>
                        <a class="button button-bord" data-bs-dismiss="modal" aria-label="Close"
                           href="javascript:void(0);">продолжить покупки</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCartError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                <svg>
                    <use xlink:href="#close"></use>
                </svg>
            </button>
            <div class="modal-body">
                <div class="modal-tx">
                    <div class="modal-tx-inner">
                        <div class="modal-tx-img">
                            <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/modal-img2.svg" alt=""></div>
                        <div class="modal-tx-cont">
                            <div class="modal-tx-cont-tt">Произошла ошибка!</div>
                            <div class="modal-tx-cont-t">В корзине максимально доступное количество данного товара</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>