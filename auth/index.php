<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Вход в личный кабинет");



if ($USER->IsAuthorized()) {
    LocalRedirect(SITE_DIR);
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
                <h1>Вход в личный кабинет</h1>
            </div>
        </div>
    </div>
    <div class="enter">
        <div class="container">
            <div class="enter__inner">
                <?
                $APPLICATION->IncludeComponent(
                    "affetta:promo_reg_form",
                    "auth",
                    Array(
                        "FIELDS" => array(
                            [
                                "type" => "text",
                                "name" => "PHONE",
                                "placeholder" => "+7(___) --- -- --",
                                "class" => "enter__item-field phone-mask",
                                "required" => 'Y'
                            ],
                        ),
                        "ACTION" => "SEND_CODE",
                        "FORM_NAME" => 'Авторизация',
                        "SHOW_LINK" => 'Y'
                    )
                );
                ?>
            </div>
        </div>
    </div>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");