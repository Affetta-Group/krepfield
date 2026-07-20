<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/* @var array $metaTags
 * @global CMain $APPLICATION
 */
if (empty($metaTags)) {
    $APPLICATION->SetTitle("Контакты");
    $APPLICATION->SetPageProperty('description', 'Контакты');
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
                <h1><?= !empty($metaTags['TITLE']) ? $metaTags['TITLE'] : 'Контакты' ?></h1>
            </div>
        </div>
    </div>
    <div class="contacts">
        <div class="container">
            <div class="contacts__inner">
                <div class="contacts__content">
                    <div class="contacts__content-title">Москва</div>
                    <div class="contacts__content-item">
                        <div class="contacts__content-item-title">Адрес</div>
                        <div class="contacts__content-item-tx">
                            <?= htmlspecialcharsback($GLOBALS["ADDRESS"]) ?>
                        </div>
                    </div>
                    <div class="contacts__content-item warning">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/warning.svg">
                        <div class="contacts__content-item-warning-text">
                            <div class="contacts__content-item-tx"><strong>ВНИМАНИЕ!</strong></div>
                            <div class="contacts__content-item-tx">
                                <?= $GLOBALS["WARNING"] ?>
                            </div>
                        </div>
                    </div>
                    <div class="contacts__content-item">
                        <div class="contacts__content-item-title">Телефон</div>
                        <div class="contacts__content-item-tel"><a
                                    href="tel:<?= $GLOBALS["PHONE_MSK"] ?>"><?= $GLOBALS["PHONE_MSK"] ?></a><span> — для Москвы и Московской области</span>
                        </div>
                        <div class="contacts__content-item-tel"><a
                                    href="tel:+7 (925) 181-04-38">+7 (925) 181-04-38</a><span> — дополнительный для Москвы и Московской области</span>
                        </div>
                        <!--
                        <div class="contacts__content-item-tel"><a
                                    href="tel:<?= $GLOBALS["PHONE"] ?>"><?= $GLOBALS["PHONE"] ?></a><span> — бесплатный звонок по всей России</span>
                        </div> -->
                    </div>
                    <div class="contacts__content-item">
                        <div class="contacts__content-item-title">E-mail</div>
                        <a class="contacts__content-item-mail"
                           href="mailto:<?= $GLOBALS["EMAIL"] ?>"><?= $GLOBALS["EMAIL"] ?></a>
                    </div>
                    <?if (!empty($GLOBALS["WORKTIME"])):?>
                    <div class="contacts__content-item">
                        <div class="contacts__content-item-title">Режим работы</div>
                        <div class="contacts__content-item-tx"><?= htmlspecialcharsback($GLOBALS["WORKTIME"]) ?></div>
                    </div>
                    <?endif;?>
                    <?if (!empty($GLOBALS["REQUESITS"])):?>
                    <div class="contacts__content-item-tel">
                        <div class="contacts__content-item-title">Юридические реквизиты</div>
                        <div class="contacts__content-item-tx"><?= htmlspecialcharsback($GLOBALS["REQUESITS"]) ?></div>
                    </div>
                    <a href="/REQUESITS.pdf" target="_blank">Скачать полные реквизиты компании</a>
                    <?endif;?>
                    
                </div>
                <? $APPLICATION->IncludeComponent(
                    "custom:form",
                    "about",
                    array(
                        'IBLOCK_ID' => '1',
                        'MAIL_EVENT' => 'FORM_SENDED',
                        'ACTIVE' => 'Y',
                        'TOKEN' => 'form002',
                        'FORM_NAME' => 'Остались вопросы',
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
    <div class="map">
        <div id="map"></div>
    </div>
    <script type="application/javascript">
        'use strict';
        $(function () {
            ymaps.ready(init);

            function init() {
                var myMap1 = new ymaps.Map("map", {
                    center: [<?= $GLOBALS["COORDS"] ?>],
                    zoom: 13,
                    controls: ["zoomControl"]
                });

                myMap1.controls.add('fullscreenControl', {float: 'left'});
                myMap1.geoObjects.add(new ymaps.Placemark([<?= $GLOBALS["COORDS"] ?>], {
                    balloonContent: ''
                }, {
                    iconLayout: 'default#image',
                    iconImageHref: '<?=SITE_TEMPLATE_PATH?>/assets/images/svg/pinmap.svg',
                    iconImageSize: [76, 97],
                    iconImageOffset: [-35, -80]
                }));
            }
        });
    </script>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");