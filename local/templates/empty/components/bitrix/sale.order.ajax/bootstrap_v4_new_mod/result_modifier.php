<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */
global $USER;

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);
if(empty($arResult["ORDER"]) && $_GET["ORDER_ID"] && $USER->IsAdmin()){
//    get order by id
    $order = Bitrix\Sale\Order::load($arResult["ORDER_ID"]);

    $arResult["ORDER_ID"] = $_GET["ORDER_ID"];
    $arResult["ORDER"]["USER_ID"] = $order->getUserId();
    $arResult["ORDER"]["DELIVERY_ID"] = $order->getDeliverySystemId()[0];
    $arResult["ORDER"]["PRICE_DELIVERY"] = $order->getDeliveryPrice();
    $arResult["WEIGHT"] = $order->getField("ORDER_WEIGHT");
    $arResult["PAY_SYSTEM_ID"] = $order->getPaymentSystemId()[0];
}