<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/* @var array $metaTags
 * @global CMain $APPLICATION
 */
if (empty($metaTags)) {
    $APPLICATION->SetTitle("О компании");
    $APPLICATION->SetPageProperty('description', 'О компании');  
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
                <h1><?= !empty($metaTags['TITLE']) ? $metaTags['TITLE'] : 'О компании KREPFIELD' ?></h1>
            </div>
        </div>
    </div>
    <div class="about">
        <div class="container">
            <div class="about__inner">
                <div class="about__content">
                    <div class="article__about">
                        <div class="article__tx article__txx">
                            <div class="article__tx-img"
                                 style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/art-img3.jpg')"></div>
                            <div class="article__tx-list">
                                <div class="article__tx-list-item">
                                    <div class="article__tx-list-inner"><img
                                                src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/ar-icon1.svg"
                                                alt="">
                                        <div class="article__tx-list-tx">Весь товар <br>сертифицирован</div>
                                    </div>
                                </div>
                                <div class="article__tx-list-item">
                                    <div class="article__tx-list-inner"><img
                                                src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/ar-icon2.svg"
                                                alt="">
                                        <div class="article__tx-list-tx">Удобная и быстрая<br> доставка</div>
                                    </div>
                                </div>
                                <div class="article__tx-list-item">
                                    <div class="article__tx-list-inner"><img
                                                src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/ar-icon3.svg"
                                                alt="">
                                        <div class="article__tx-list-tx">Персональный <br>консультант</div>
                                    </div>
                                </div>
                                <div class="article__tx-list-item">
                                    <div class="article__tx-list-inner"><img
                                                src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/ar-icon4.svg"
                                                alt="">
                                        <div class="article__tx-list-tx">Комплексные<br> решения</div>
                                    </div>
                                </div>
                            </div>
                            <?= htmlspecialcharsback($GLOBALS["ABOUT"]) ?>
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
                    'TOKEN' => 'form001',
                    'FORM_NAME' => 'Форма со страницы О компании',
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