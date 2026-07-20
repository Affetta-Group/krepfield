<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

global $APPLICATION;

$aMenuLinks = array(
    array(
        "Личные данные",
        "/personal/private/",
        array(),
        array(
            "SVG" => "#tab-icon1"
        ),
        ""
    ),
    array(
        "Текущие заказы",
        "/personal/orders/",
        array(),
        array(
            "SVG" => "#tab-icon2"
        ),
        ""
    ),
    array(
        "История заказов",
        "/personal/orders/?filter_history=Y",
        array(),
        array(
            "SVG" => "#tab-icon3"
        ),
        ""
    ),
    array(
        "Выйти",
        $APPLICATION->GetCurPageParam("logout=yes&" . bitrix_sessid_get(), array("logout")),
        array(),
        array(
            "SVG" => "#tab-icon4"
        ),
        ""
    ),
);
?>