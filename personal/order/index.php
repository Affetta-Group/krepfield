<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");
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
                <h1>Оформление заказа</h1>
            </div>
        </div>
    </div>
    <div class="cart-order">
        <? $APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax", 
	"bootstrap_v4_new_mod", 
	[
		"PAY_FROM_ACCOUNT" => "Y",
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"ALLOW_AUTO_REGISTER" => "Y",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"DELIVERY_NO_AJAX" => "N",
		"SHOW_COUPONS" => "Y",
		"TEMPLATE_LOCATION" => "popup",
		"PROP_1" => "",
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_PERSONAL" => "/personal/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PATH_TO_ORDER" => "/personal/order/",
		"SET_TITLE" => "Y",
		"SHOW_ACCOUNT_NUMBER" => "Y",
		"DELIVERY_NO_SESSION" => "Y",
		"COMPATIBLE_MODE" => "N",
		"BASKET_POSITION" => "before",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"SERVICES_IMAGES_SCALING" => "adaptive",
		"USER_CONSENT" => "Y",
		"USER_CONSENT_ID" => "1",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "Y",
		"COMPONENT_TEMPLATE" => "bootstrap_v4_new_mod",
		"ALLOW_APPEND_ORDER" => "Y",
		"SHOW_NOT_CALCULATED_DELIVERIES" => "L",
		"SPOT_LOCATION_BY_GEOIP" => "Y",
		"DELIVERY_TO_PAYSYSTEM" => "p2d",
		"SHOW_VAT_PRICE" => "Y",
		"USE_PREPAYMENT" => "N",
		"USE_PRELOAD" => "N",
		"ALLOW_USER_PROFILES" => "N",
		"ALLOW_NEW_PROFILE" => "N",
		"TEMPLATE_THEME" => "blue",
		"SHOW_ORDER_BUTTON" => "final_step",
		"SHOW_TOTAL_ORDER_BUTTON" => "N",
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
		"SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
		"SHOW_DELIVERY_LIST_NAMES" => "Y",
		"SHOW_DELIVERY_INFO_NAME" => "Y",
		"SHOW_DELIVERY_PARENT_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "Y",
		"SKIP_USELESS_BLOCK" => "Y",
		"SHOW_BASKET_HEADERS" => "N",
		"DELIVERY_FADE_EXTRA_SERVICES" => "N",
		"SHOW_NEAREST_PICKUP" => "N",
		"DELIVERIES_PER_PAGE" => "9",
		"PAY_SYSTEMS_PER_PAGE" => "9",
		"PICKUPS_PER_PAGE" => "5",
		"SHOW_PICKUP_MAP" => "N",
		"SHOW_MAP_IN_PROPS" => "N",
		"PICKUP_MAP_TYPE" => "yandex",
		"SHOW_COUPONS_BASKET" => "Y",
		"SHOW_COUPONS_DELIVERY" => "N",
		"SHOW_COUPONS_PAY_SYSTEM" => "N",
		"PROPS_FADE_LIST_1" => [
		],
		"ACTION_VARIABLE" => "soa-action",
		"PATH_TO_AUTH" => "/auth/",
		"DISABLE_BASKET_REDIRECT" => "N",
		"EMPTY_BASKET_HINT_PATH" => "/",
		"USE_PHONE_NORMALIZATION" => "Y",
		"PRODUCT_COLUMNS_VISIBLE" => [
			0 => "PREVIEW_PICTURE",
			1 => "PROPS",
			2 => "PROPERTY_KF_DLYA_SAYTA_NAIMENOVANIE",
		],
		"ADDITIONAL_PICT_PROP_12" => "-",
		"ADDITIONAL_PICT_PROP_13" => "-",
		"PRODUCT_COLUMNS_HIDDEN" => [
		],
		"HIDE_ORDER_DESCRIPTION" => "N",
		"USE_YM_GOALS" => "N",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_CUSTOM_MAIN_MESSAGES" => "N",
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
		"USE_CUSTOM_ERROR_MESSAGES" => "N",
		"ADDITIONAL_PICT_PROP_6" => "-",
		"ADDITIONAL_PICT_PROP_9" => "-",
		"PROPS_FADE_LIST_2" => [
		],
		"ADDITIONAL_PICT_PROP_10" => "-",
		"USER_CONSENT_IDS" => [
			0 => "1",
		],
		"USER_CONSENT_IS_CHECKED_1" => "Y",
		"USER_CONSENT_REQUIRED_1" => "Y"
	],
	false
);
        ?>
    </div>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");