<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Бонусная регистрация");

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
                <h1>Регистрация</h1>
            </div>
        </div>
    </div>

    <?
    $APPLICATION->IncludeComponent(
        "affetta:promo_reg_form",
        "main",
        Array(
            "FIELDS" => array(
                [
                    "type" => "text",
                    "name" => "NAME",
                    "placeholder" => "Имя",
                    "class" => "enter__item-field",
                    "required" => 'Y'
                ],
                [
                    "type" => "text",
                    "name" => "SUNAME",
                    "placeholder" => "Фамилия",
                    "class" => "enter__item-field",
                ],
                [
                    "type" => "text",
                    "name" => "PHONE",
                    "placeholder" => "+7(___) --- -- --",
                    "class" => "enter__item-field phone-mask",
                    "required" => 'Y'
                ],
                [
                    "type" => "text",
                    "name" => "EMAIL",
                    "placeholder" => "Почта",
                    "class" => "enter__item-field",
                    "required" => 'Y'
                ],
                [
                    "type" => "text",
                    "name" => "PROMOCODE",
                    "placeholder" => "Промокод",
                    "class" => "enter__item-field",
                    "required" => 'Y'
                ],
            ),
            "ACTION" => "REGISTER_CODE",
            "FORM_NAME" => 'Регистрация по промокоду',
            "SHOW_LINK" => 'Y'
        )
    );

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");