<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/* @var array $metaTags
 * @global CMain $APPLICATION
 */
if (empty($metaTags)) {
    $APPLICATION->SetTitle("Оплата и доставка");
    $APPLICATION->SetPageProperty('description', 'Оплата и доставка');
}
?>
    <div class="page-top">
        <div class="container">
            <div class="page-top__inner">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "main",
                    array(
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => "s1"
                    )
                );
                ?>
                <h1><?= !empty($metaTags['TITLE']) ? $metaTags['TITLE'] : 'Оплата и доставка' ?></h1>
            </div>
        </div>
    </div>
    <div class="delivery">
        <div class="container">
            <div class="delivery__inner">
                <div class="delivery__content">
                    <h2>Способы доставки</h2>
                    <div class="accordion" id="accordionExample">
<!--                        <div class="accordion-item">-->
<!--                            <div class="accordion-header" id="headingOne">-->
<!--                                <button class="accordion-button" type="button" data-bs-toggle="collapse"-->
<!--                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">-->
<!--                                    Самовывоз-->
<!--                                </button>-->
<!--                            </div>-->
<!--                            <div class="accordion-collapse collapse show" id="collapseOne" aria-labelledby="headingOne"-->
<!--                                 data-bs-parent="#accordionExample">-->
<!--                                <div class="accordion-body">-->
<!--                                    <div class="delivery__tx">-->
<!--                                        <div class="delivery__tx-tb" style="display:none;">-->
<!--                                            <div class="delivery__tx-tb-row">-->
<!--                                                <div class="delivery__tx-tb-cell">Минимальная сумма заказа</div>-->
<!--                                                <div class="delivery__tx-tb-cell">900 ₽</div>-->
<!--                                            </div>-->
<!--                                            <div class="delivery__tx-tb-row">-->
<!--                                                <div class="delivery__tx-tb-cell">Доставка от 2000 рублей в зависимости-->
<!--                                                    от региона-->
<!--                                                </div>-->
<!--                                                <div class="delivery__tx-tb-cell">Бесплатно</div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <div class="delivery__tx-list" style="display:none;">-->
<!--                                            <ul>-->
<!--                                                <li>При оформлении заказа выбрать удобный для себя пункт</li>-->
<!--                                                <li>Калькулятор на сайте посчитает стоимость доставки</li>-->
<!--                                                <li>При оформлении заказа выбрать удобный для себя пункт</li>-->
<!--                                                <li>Оплата наличными и банковской картой</li>-->
<!--                                            </ul>-->
<!--                                            <div class="delivery__tx-list-gr">-->
<!--                                                <div class="delivery__tx-list-gr-item">Минимальная сумма заказа: 900 ₽-->
<!--                                                </div>-->
<!--                                                <div class="delivery__tx-list-gr-item">Бесплатная доставка от 2000-->
<!--                                                    рублей в зависимости от региона-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <div class="delivery__tx-list">-->
<!--                                            <p>Товар можно забрать по адресу: 108811, Москва г, вн.тер.г. поселение Московский, км Киевское шоссе 22-й (п Московский), двлд. 4, стр. 1, этаж 5, блок А</p>-->
<!--                                            <p>Самовывоз производится <span style="font-weight: bold">по предварительной записи по телефону +79688313617</span></p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="accordion-item">
                            <div class="accordion-header" id="headingTw">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTw" aria-expanded="false" aria-controls="collapseTw">
                                    Boxberry
                                </button>
                            </div>
                            <div class="accordion-collapse collapse" id="collapseTw" aria-labelledby="headingTw"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="delivery__tx">
                                        <div class="delivery__tx-tb" style="display:none;">
                                            <div class="delivery__tx-tb-row">
                                                <div class="delivery__tx-tb-cell">Минимальная сумма заказа</div>
                                                <div class="delivery__tx-tb-cell">900 ₽</div>
                                            </div>
                                            <div class="delivery__tx-tb-row">
                                                <div class="delivery__tx-tb-cell">Доставка от 2000 рублей в зависимости
                                                    от региона
                                                </div>
                                                <div class="delivery__tx-tb-cell">Бесплатно</div>
                                            </div>
                                        </div>
                                        <div class="delivery__tx-list" style="display:none;">
                                            <ul>
                                                <li>При оформлении заказа выбрать удобный для себя пункт</li>
                                                <li>Калькулятор на сайте посчитает стоимость доставки</li>
                                                <li>При оформлении заказа выбрать удобный для себя пункт</li>
                                                <li>Оплата наличными и банковской картой</li>
                                            </ul>
                                            <div class="delivery__tx-list-gr">
                                                <div class="delivery__tx-list-gr-item">Минимальная сумма заказа: 900 ₽
                                                </div>
                                                <div class="delivery__tx-list-gr-item">Бесплатная доставка от 2000
                                                    рублей в зависимости от региона
                                                </div>
                                            </div>
                                        </div>
                                        <div class="delivery__tx-list">
                                            <p>Boxberry - быстрая и надежная доставка по всей России. Срок доставки от 1 до 4 дней. Варианты доставки: доставка курьером до двери; доставка в пункт выдачи.</p>
                                            <p>Стоимость доставки рассчитывается автоматически во время оформления заказа и суммируется со стоимостью товаров.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header" id="headingFr">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFr" aria-expanded="false" aria-controls="collapseFr">
                                    СДЭК
                                </button>
                            </div>
                            <div class="accordion-collapse collapse" id="collapseFr" aria-labelledby="headingFr"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="delivery__tx">
                                        <div class="delivery__tx-tb" style="display:none;">
                                            <div class="delivery__tx-tb-row">
                                                <div class="delivery__tx-tb-cell">Минимальная сумма заказа</div>
                                                <div class="delivery__tx-tb-cell">900 ₽</div>
                                            </div>
                                            <div class="delivery__tx-tb-row">
                                                <div class="delivery__tx-tb-cell">Доставка от 2000 рублей в зависимости
                                                    от региона
                                                </div>
                                                <div class="delivery__tx-tb-cell">Бесплатно</div>
                                            </div>
                                        </div>
                                        <div class="delivery__tx-list" style="display:none;">
                                            <ul>
                                                <li>При оформлении заказа выбрать удобный для себя пункт</li>
                                                <li>Калькулятор на сайте посчитает стоимость доставки</li>
                                                <li>При оформлении заказа выбрать удобный для себя пункт</li>
                                                <li>Оплата наличными и банковской картой</li>
                                            </ul>
                                            <div class="delivery__tx-list-gr">
                                                <div class="delivery__tx-list-gr-item">Минимальная сумма заказа: 900 ₽
                                                </div>
                                                <div class="delivery__tx-list-gr-item">Бесплатная доставка от 2000
                                                    рублей в зависимости от региона
                                                </div>
                                            </div>
                                        </div>
                                        <div class="delivery__tx-list">
                                            <p>СДЭК осуществляет доставку по регионам России и СНГ. Срок доставки 2-3 дня. Варианты доставки: доставка курьером до двери; доставка в пункт выдачи; доставка до постамата.</p>
                                            <p>Стоимость доставки рассчитывается автоматически во время оформления заказа и суммируется со стоимостью товаров.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="delivery-dev">
                        <h2>Способы оплаты</h2>
                        <div class="delivery-dev-list">
                            <div class="delivery-dev-list-item">
                                <div class="delivery-dev-list-item-img"><img
                                            src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/dv1.svg" alt=""></div>
                                <div class="delivery-dev-list-item-title">Онлайн на сайте</div>
                                <div class="delivery-dev-list-item-tx">
                                    После поступления оплаты Ваш заказ будет сформирован и зарезервирован на 3 рабочих дня
                                </div>
                            </div>
                            <div class="delivery-dev-list-item" style="display:none;">
                                <div class="delivery-dev-list-item-img"><img
                                            src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/dv2.svg" alt=""></div>
                                <div class="delivery-dev-list-item-title">Банковской картой при получении</div>
                                <div class="delivery-dev-list-item-tx">Удобная доставка в пункты выдачи позволит вам
                                    легко и быстро получить свой заветный заказ! 308 городов России от запада до
                                    востока. Минимальная сумма заказа: 900 руб. Бесплатная доставка от 3000 рублей в
                                    зависимости от региона
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <? $APPLICATION->IncludeComponent(
                    "custom:form",
                    "about",
                    array(
                        'IBLOCK_ID' => '1',
                        'MAIL_EVENT' => 'FORM_SENDED',
                        'ACTIVE' => 'Y',
                        'TOKEN' => 'form003',
                        'FORM_NAME' => 'Форма со страницы Доставка и оплата',
                        'PROPS' => array(
                            'NAME', // type - string
                            'PHONE', // type - string
                            'QUESTION', // type - string
                            'FORM_NAME',
                            'URL',
                        ),
                    )
                ); ?>
            </div>
        </div>
    </div>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");