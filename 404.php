<?
include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");
?>
    <div class="page-top">
        <div class="container">
            <div class="page-top__inner"></div>
        </div>
    </div>
    <div class="all tw">
        <div class="container">
            <div class="all__inner">
                <div class="all__img"><img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/b4.png" alt=""></div>
                <div class="all__title">Страница не найдена</div>
                <div class="all__tx">Упс! Возможно, вы ввели неправильный <br>адрес или она была удалена.</div>
                <div class="all__btn"><a class="button button-black" href="<?= SITE_DIR ?>">Вернуться на главную</a>
                </div>
            </div>
        </div>
    </div>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>