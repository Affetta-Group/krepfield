<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */

/** @var CBitrixComponent $component */

use Bitrix\Main,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Page\Asset,
    Bitrix\Main\Grid\Declension;

Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/script.js");
Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/style.css");
CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);
$APPLICATION->SetTitle($_REQUEST["filter_history"] === "Y" ? 'История заказов' : 'Текущие заказы');

if (is_array($arResult["ORDERS"]) && !empty($arResult["ORDERS"]) && $_GET["PAYED"]) {
    $orderId = $arResult["ORDERS"][array_key_first($arResult["ORDERS"])]["ORDER"]["ID"];
    LocalRedirect("/personal/orders/" . $orderId . "/");
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
            <h1><?= $_REQUEST["filter_history"] === "Y" ? 'История заказов' : 'Текущие заказы' ?></h1>
        </div>
    </div>
</div>
<div class="orders">
    <div class="container">
        <div class="orders__inner">
            <div class="orders__left">
                <?php if (!empty($arResult['ERRORS']['FATAL'])) {
                    foreach ($arResult['ERRORS']['FATAL'] as $error) {
                        ShowError($error);
                    }
                } else {
                    if (!empty($arResult['ERRORS']['NONFATAL'])) {
                        foreach ($arResult['ERRORS']['NONFATAL'] as $error) {
                            ShowError($error);
                        }
                    }
                    if ($_REQUEST["filter_history"] === "Y") {
                        if (!empty($arResult["ORDERS"])) {
                            ?>
                            <div class="accordion" id="accordionExample">
                                <?
                                foreach ($arResult["ORDERS"] as $i => $arOrder):
                                    $orderCount = count($arOrder["BASKET_ITEMS"]); ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                <div class="orders__title">
                                                    <div class="orders__title-main">Заказ
                                                        №<?= $arOrder["ORDER"]["ID"] ?>
                                                        от <?= $arOrder["ORDER"]["DATE_INSERT_FORMATED"] ?></div>
                                                    <div class="orders__title-min"><?= $orderCount . " " . (new Declension('товар', 'товара', 'товаров'))->get($orderCount) . " на сумму " . $arOrder["ORDER"]["FORMATED_PRICE"] . " ₽" ?></div>
                                                </div>
                                                <div class="orders__status orders__status-suc">Заказ выполнен
                                                </div>
                                            </button>
                                        </div>
                                        <div class="accordion-collapse collapse <?= $i === array_key_first($arResult["ORDERS"]) ? 'show' : '' ?>"
                                             id="collapseOne" aria-labelledby="headingOne"
                                             data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <?php foreach ($arOrder["BASKET_ITEMS"] as $arItem): ?>
                                                    <div class="catalog__item">
                                                        <a class="catalog__item-img"
                                                           href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                                                            <img src="<?= $arItem["PRODUCT_INFO"]["PREVIEW_PICTURE"]["src"] ?>"
                                                                 alt="">
                                                        </a>
                                                        <a class="catalog__item-title"
                                                           href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?= !empty($arItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_NAIMENOVANIE_VALUE"]) ? $arItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_NAIMENOVANIE_VALUE"] : $arItem["NAME"] ?></a>
                                                        <div class="catalog__item-list">
                                                            <? if (!empty($arItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_KRATNOST_UPAKOVKI_VALUE"])): ?>
                                                                <div class="catalog__item-list-item">
                                                                    Упаковка: <?= $arItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_KRATNOST_UPAKOVKI_VALUE"] ?>
                                                                    шт
                                                                </div>
                                                            <? endif; ?>
                                                            <? if (!empty($arItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_MATERIAL_VALUE"])): ?>
                                                                <div class="catalog__item-list-item">
                                                                    Материал: <?= $arItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_MATERIAL_VALUE"] ?></div>
                                                            <? endif; ?>
                                                            <? if (!empty($arItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_DIAMETR_VALUE"])): ?>
                                                                <div class="catalog__item-list-item">
                                                                    Диаметр: <?= $arItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_DIAMETR_VALUE"] ?></div>
                                                            <? endif; ?>
                                                            <? if (!empty($arItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_DLINA_VALUE"])): ?>
                                                                <div class="catalog__item-list-item">
                                                                    Длина: <?= $arItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_DLINA_VALUE"] ?></div>
                                                            <? endif; ?>
                                                        </div>
                                                        <div class="catalog__item-numb"><?= $arItem["QUANTITY"] ?> шт
                                                        </div>
                                                        <div class="catalog__item-price">
                                                            <div class="catalog__item-price-now"><?= CurrencyFormat($arItem["PRICE"], "RUB") ?></div>
                                                            <!-- <div class="catalog__item-price-old">63 000</div> -->
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;
                                ?>
                            </div>
                            <?
                        } else {
                            ?>
                            <div class="cart-none__title">Ваша история заказов пуста!</div>
                            <p>Перейдите в каталог, чтобы продолжить покупки</p>
                            <a class="button button-primary" href="<?= SITE_DIR ?>catalog/">перейти в каталог</a>
                            <?php
                        }
                    } else {
                        if (!empty($arResult["ORDERS"])) {
                            foreach ($arResult["ORDERS"] as $i => $arOrder):
                                $orderCount = count($arOrder["BASKET_ITEMS"]); ?>
                                <div class="orders__item">
                                    <div class="orders__top">
                                        <div class="orders__title">
                                            <div class="orders__title-main"><a
                                                        href="<?= $arOrder["ORDER"]["URL_TO_DETAIL"] ?>">Заказ
                                                    №<?= $arOrder["ORDER"]["ID"] ?></a>
                                                от <?= $arOrder["ORDER"]["DATE_INSERT_FORMATED"] ?></div>
                                            <div class="orders__title-min"><?= $orderCount . " " . (new Declension('товар', 'товара', 'товаров'))->get($orderCount) . " на сумму " . $arOrder["ORDER"]["FORMATED_PRICE"] . " ₽" ?></div>
                                        </div>
                                        <div class="orders__status orders__status-success">
                                            <?php
                                            switch ($arOrder["ORDER"]["STATUS_ID"]) {
                                                case "N":
                                                    echo 'Принят, ожидается оплата';
                                                    break;
                                                case "F":
                                                    echo 'Выполнен';
                                                    break;
                                                case "DN":
                                                    echo 'Ожидает обработки';
                                                    break;
                                                case "DF":
                                                    echo 'Отгружен';
                                                    break;
                                                case "PD":
                                                    echo 'Оплачен';
                                                    break;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($arOrder["PAYMENT"])):
                                        foreach ($arOrder["PAYMENT"] as $payment):
                                            if ($arOrder['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y') {
                                                $paymentChangeData[$payment['ACCOUNT_NUMBER']] = array(
                                                    "order" => htmlspecialcharsbx($arOrder['ORDER']['ACCOUNT_NUMBER']),
                                                    "payment" => htmlspecialcharsbx($payment['ACCOUNT_NUMBER']),
                                                    "allow_inner" => $arParams['ALLOW_INNER'],
                                                    "refresh_prices" => $arParams['REFRESH_PRICES'],
                                                    "path_to_payment" => $arParams['PATH_TO_PAYMENT'],
                                                    "only_inner_full" => $arParams['ONLY_INNER_FULL'],
                                                    "return_url" => $arResult['RETURN_URL'],
                                                );
                                            }
                                            ?>
                                            <div class="orders__item-descr sale-order-list-inner-row-body">
                                                <div class="orders__item-descr-title">Оплата</div>
                                                <div class="orders__item-descr-count">
                                                    <div class="orders__item-descr-count-tit">
                                                        <?= "Счет " . $payment["ACCOUNT_NUMBER"] . " от " . $payment["DATE_BILL_FORMATED"] . ", " . $payment["PAY_SYSTEM_NAME"] ?>
                                                        <?php if ($payment["PAY_SYSTEM_ID"] == 5): ?>
                                                            <br>
                                                            <a href="https://krepfield.ru/personal/order/?ORDER_ID=<?= $arOrder["ORDER"]["ID"] ?>&TO_PDF=TRUE">Ссылка
                                                                на счет</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <p>Сумма к оплате по счету: <?= $payment["FORMATED_SUM"] ?> руб.</p>
                                                <!--                                                --><?php //if ($payment["PAID"] !== "Y"):
                                                ?>
                                                <!--                                                    <a class="orders__item-descr-link" href="javascript:void(0);"-->
                                                <!--                                                       id="-->
                                                <?php //= htmlspecialcharsbx($payment['ACCOUNT_NUMBER'])
                                                ?><!--">Cменить-->
                                                <!--                                                        способ оплаты</a>-->
                                                <!--                                                --><?php //endif;
                                                ?>
                                            </div>
                                            <div class="sale-order-list-inner-row-template " style="display: none;">
                                                <a class="sale-order-list-cancel-payment orders__item-descr-link"
                                                   style="margin-bottom: 20px;">
                                                </a>
                                            </div>
                                        <?php
                                        endforeach;
                                    endif; ?>
                                    <? if (!empty($arOrder["SHIPMENT"])):
                                        foreach ($arOrder["SHIPMENT"] as $shipment):?>
                                            <div class="orders__item-descr">
                                                <div class="orders__item-descr-title">доставка</div>
                                                <div class="orders__item-descr-count">
                                                    <div class="orders__item-descr-count-tit">
                                                        <?= $shipment["DELIVERY_NAME"] ?>
                                                    </div>
                                                </div>
                                                <p>Сумма к оплате по
                                                    счету: <?= $shipment["FORMATED_DELIVERY_PRICE"] ?> руб.</p>
                                            </div>
                                        <?php
                                        endforeach;
                                    endif;
                                    ?>
                                    <div class="orders__item-bt">
                                        <a class="orders__item-load" href="<?= $arOrder["ORDER"]["URL_TO_COPY"] ?>">
                                            Повторить заказ<img
                                                    src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/load.svg" alt="">
                                        </a>
                                        <a class="orders__item-bottom" href="<?= $arOrder["ORDER"]["URL_TO_CANCEL"] ?>">
                                            Отменить заказ<img
                                                    src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/close-roud.svg"
                                                    alt="">
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach;
                        } else {
                            ?>
                            <div class="cart-none__title">Ваша история заказов пуста!</div>
                            <p>Перейдите в каталог, чтобы продолжить покупки</p>
                            <a class="button button-primary" href="<?= SITE_DIR ?>catalog/">перейти в каталог</a>
                            <?php
                        }
                    }
                }

                $javascriptParams = array(
                    "url" => CUtil::JSEscape($this->__component->GetPath() . '/ajax.php'),
                    "templateFolder" => CUtil::JSEscape($templateFolder),
                    "templateName" => $this->__component->GetTemplateName(),
                    "paymentList" => $paymentChangeData,
                    "returnUrl" => CUtil::JSEscape($arResult["RETURN_URL"]),
                );
                $javascriptParams = CUtil::PhpToJSObject($javascriptParams);
                ?>
                <script>
                    BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?=$javascriptParams?>);
                </script>
            </div>
            <? $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "personal",
                array(
                    "ROOT_MENU_TYPE" => "personal",
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "top",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "N",
                    "MENU_CACHE_GET_VARS" => ""
                )
            ); ?>
        </div>
    </div>
</div>