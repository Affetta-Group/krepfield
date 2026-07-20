<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Расшириная регистрация");

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


$obEnum = new CUserFieldEnum;
$rsEnum = $obEnum->GetList(array(), array("USER_FIELD_ID" => 100));

while ($arEnum = $rsEnum->GetNext()) {
//    rdd($arEnum,true);
    $ext_fields[] = [
        "type" => "checkbox",
        "name" => "POSITION-".$arEnum['ID'],
        "placeholder" => $arEnum['VALUE'],
        "class" => "enter__item-field",
    ];
}

$obEnum = new CUserFieldEnum;
$rsEnum = $obEnum->GetList(array(), array("USER_FIELD_ID" => 98));

$ext_fields2[] = [
    "type" => "option",
    "name" => "",
    "placeholder" => "Форма организации",
    "class" => "",
];
while ($arEnum = $rsEnum->GetNext()) {
//    rdd($arEnum,true);
    $ext_fields2[] = [
        "type" => "option",
        "name" => "ORG-".$arEnum['ID'],
        "placeholder" => $arEnum['VALUE'],
        "class" => "",
    ];
}

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
//                [
//                    "type" => "select",
//                    "name" => "ORG",
//                    "placeholder" => "Форма организации",
//                    "class" => "enter__item-field",
//                    "required" => 'Y',
//                    "ext" => $ext_fields2
//                ],
//
//                [
//                    "type" => "multiselect_ext",
//                    "name" => "POSITION",
//                    "class" => "enter__item-field",
//                    "placeholder" => "Типы работ",
//                    "required" => 'Y',
//                    "ext" => $ext_fields
//                ],

//                [
//                    "type" => "checkbox",
//                    "name" => "CLAIM",
//                    "placeholder" => "Подать заявку на участие в программе лояльности",
//                    "class" => "",
//                    "required" => 'Y'
//                ],
            ),
            "ACTION" => "REGISTER_PROF",
            "FORM_NAME" => 'Регистрация проффессионала',
            "SHOW_AUTH_LINK" => 'Y',
            "SHOW_PROMO_LINK" => 'N',
        )
); ?>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");