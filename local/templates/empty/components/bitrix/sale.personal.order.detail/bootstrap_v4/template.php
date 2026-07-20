<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\Page\Asset,
    Bitrix\Main\Grid\Declension;

if ($arParams['GUEST_MODE'] !== 'Y') {
    Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/script.js");
    Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/style.css");
}
CJSCore::Init(array('clipboard', 'fx'));

$APPLICATION->SetTitle("Подробная информация о заказе");
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
            <h1>Подробная информация о заказе</h1>
        </div>
    </div>
</div>
<div class="orders">
    <div class="container">
        <div class="orders__inner">
            <div class="orders__left tw">
                <div class="orders__top orders__top-big">
                    <div class="orders__title">
                        <div class="orders__title-main">
                            <?= Loc::getMessage('SPOD_LIST_MY_ORDER', array(
                                '#ACCOUNT_NUMBER#' => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),
                                '#DATE_ORDER_CREATE#' => $arResult["DATE_INSERT_FORMATED"]
                            )) ?>
                        </div>
                        <div class="orders__title-min"><?= count($arResult['BASKET']) . " " . (new Declension('товар', 'товара', 'товаров'))->get(count($arResult['BASKET'])) . " на сумму " . $arResult["PRICE_FORMATED"] . " руб." ?></div>
                    </div>
                    <div class="orders__status orders__status-success">
                        <? switch ($arResult["STATUS_ID"]) {
                            case "N":
                                echo 'Принят, ожидается оплата';
                                break;
                            case "F":
                                echo 'Заказ выполнен';
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
                        } ?>
                    </div>
                </div>

                <? if (isset($arResult["ORDER_PROPS"])): ?>
                    <div class="orders__item-descr orders__item-descr-recipient">
                        <div class="orders__item-descr-title">информация о заказе</div>
                        <div class="orders__item-descr-title mb-0">ФИО</div>
                        <div class="orders__item-descr-recipient-tx"><?= $arResult["ORDER_PROPS"]["0"]["VALUE"] ?></div>
                    </div>
                <? endif; ?>
                <?php foreach ($arResult['PAYMENT'] as $payment): ?>
                    <div class="orders__item-descr th sale-order-detail-payment-options-methods">
                        <div class="orders__item-descr-title">параметры оплаты</div>
                        <div class="col sale-order-detail-payment-options-methods-info">
                            <div class="orders__item-descr-count">
                                <div class="orders__item-descr-count-tit">
                                    <?php
                                    $paymentData[$payment['ACCOUNT_NUMBER']] = array(
                                        "payment" => $payment['ACCOUNT_NUMBER'],
                                        "order" => $arResult['ACCOUNT_NUMBER'],
                                        "allow_inner" => $arParams['ALLOW_INNER'],
                                        "only_inner_full" => $arParams['ONLY_INNER_FULL'],
                                        "refresh_prices" => $arParams['REFRESH_PRICES'],
                                        "path_to_payment" => $arParams['PATH_TO_PAYMENT']
                                    );
                                    $paymentSubTitle = Loc::getMessage('SPOD_TPL_BILL') . " " . Loc::getMessage('SPOD_NUM_SIGN') . $payment['ACCOUNT_NUMBER'];
                                    if (isset($payment['DATE_BILL'])) {
                                        $paymentSubTitle .= " " . Loc::getMessage('SPOD_FROM') . " " . $payment['DATE_BILL_FORMATED'];
                                    }
                                    $paymentSubTitle .= ", ";
                                    $paymentSubTitle .= $payment['PAY_SYSTEM_NAME'];
                                    echo htmlspecialcharsbx($paymentSubTitle);
                                    ?>
                                </div>
                            </div>
                            <p><?= Loc::getMessage('SPOD_ORDER_PRICE_BILL') ?>: <?= $payment['PRICE_FORMATED'] ?>
                                руб.</p>
                            <? if ($payment['PAID'] !== 'Y' && $arResult['CANCELED'] !== 'Y' && $arParams['GUEST_MODE'] !== 'Y'
                                && $arResult['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'): ?>
                                <a class="orders__item-descr-link" href="javascript:void(0);"
                                   id="<?= $payment['ACCOUNT_NUMBER'] ?>">
                                    Cменить способ оплаты
                                </a>
                            <? endif; ?>
                        </div>
                        <?php
                        if ($arResult['IS_ALLOW_PAY'] === 'N' && $payment['PAID'] !== 'Y') {
                            ?>
                            <div class="sale-order-detail-status-restricted-message-block">
                                <span class="sale-order-detail-status-restricted-message"><?= Loc::getMessage('SOPD_TPL_RESTRICTED_PAID_MESSAGE') ?></span>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                        if ($payment['PAY_SYSTEM']["IS_CASH"] !== "Y" && $payment['PAY_SYSTEM']['ACTION_FILE'] !== 'cash') {
                            ?>
                            <div class="col-sm-auto col-12 sale-order-detail-payment-options-methods-button-container">
                                <?php if ($payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] === 'Y' && $arResult["IS_ALLOW_PAY"] !== "N") {
                                    ?>
                                    <a class="button button-black" target="_blank"
                                       href="<?= htmlspecialcharsbx($payment['PAY_SYSTEM']['PSA_ACTION_FILE']) ?>"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></a>
                                    <?php
                                } else if ($payment["PAID"] === "Y" || $arResult["CANCELED"] === "Y" || $arResult["IS_ALLOW_PAY"] === "N") {
                                    ?>
                                    <button class="button button-black disabled"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></button>
                                    <?php
                                } else {
                                    ?>
                                    <button class="button button-black active-button"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></button>

                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }else{
                        ?>
                            <a href="https://krepfield.ru/personal/order/?ORDER_ID=<?= $arResult["ID"] ?>&TO_PDF=TRUE"" class="button button-black active-button">Оплатить
                            </a>
                        <?php
                        }?>
                        <div class="sale-order-detail-payment-inner-row-template col-12">
                            <a href="" onclick="return false"
                               class="sale-order-list-cancel-payment">
                                <i class="fa fa-long-arrow-left"></i> <?= Loc::getMessage('SPOD_CANCEL_PAYMENT') ?>
                            </a>
                        </div>
                        <?php
                         if ($payment["PAID"] !== "Y"
                            && $payment['PAY_SYSTEM']["IS_CASH"] !== "Y"
                            && $payment['PAY_SYSTEM']['ACTION_FILE'] !== 'cash'
                            && $payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] !== 'Y'
                            && $arResult['CANCELED'] !== 'Y'
                            && $arResult["IS_ALLOW_PAY"] !== "N") {
                            ?>
                            <div class="row sale-order-detail-payment-options-methods-template">
														<span class="sale-paysystem-close active-button">
															<span class="sale-paysystem-close-item sale-order-payment-cancel"></span>
                                                            <!--sale-paysystem-close-item-->
														</span><!--sale-paysystem-close-->
                                <div class="col">
                                    <?= $payment['BUFFERED_OUTPUT'] ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                <? endforeach; ?>
                <? foreach ($arResult['SHIPMENT'] as $shipment): ?>
                    <div class="orders__item-descr">
                        <div class="orders__item-descr-title">параметры доставки</div>
                        <div class="orders__item-descr-lt">
                            <div class="orders__item-descr-lt-item">
                                <div class="orders__item-descr-lt-item-title">Способ доставки</div>
                                <div class="orders__item-descr-lt-item-tx"><?= htmlspecialcharsbx($shipment["DELIVERY_NAME"]) ?></div>
                            </div>
                            <div class="orders__item-descr-lt-item">
                                <div class="orders__item-descr-lt-item-title">Статус отгрузки</div>
                                <div class="orders__item-descr-lt-item-tx"><?= htmlspecialcharsbx($shipment['STATUS_NAME']) ?></div>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
                <div class="orders__item-descr">
                    <div class="orders__item-descr-title">Содержимое заказа</div>
                    <?
                    foreach ($arResult['BASKET'] as $basketItem):?>
                        <div class="catalog__item">
                            <? if (!empty($basketItem['DETAIL_PICTURE']['SRC'])): ?>
                                <a class="catalog__item-img"
                                   href="<?= $basketItem['DETAIL_PAGE_URL'] ?>">
                                    <img src="<?= $basketItem['DETAIL_PICTURE']['SRC'] ?>"
                                         alt="">
                                </a>
                            <? else: ?>
                                <a class="catalog__item-img"
                                   href="<?= $basketItem['DETAIL_PAGE_URL'] ?>">
                                    <img src="<?= SITE_TEMPLATE_PATH . "/assets/images/svg/no-img.svg" ?>"
                                         alt="">
                                </a>
                            <? endif; ?>
                            <a class="catalog__item-title"
                               href="<?= $basketItem['DETAIL_PAGE_URL'] ?>">
                                <?= !empty($basketItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_NAIMENOVANIE_VALUE"]) ? $basketItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_NAIMENOVANIE_VALUE"] : $basketItem["NAME"] ?>
                            </a>
                            <div class="catalog__item-list">
                                 <? if (!empty($basketItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_KRATNOST_UPAKOVKI_VALUE"])): ?>
                                <div class="catalog__item-list-item">Упаковка: <?= $basketItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_KRATNOST_UPAKOVKI_VALUE"] ?> шт</div>
                                 <? endif; ?>
                                 <? if (!empty($basketItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_MATERIAL_VALUE"])): ?>
                                <div class="catalog__item-list-item">Материал: <?= $basketItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_MATERIAL_VALUE"] ?></div>
                                 <? endif; ?>
                                 <? if (!empty($basketItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_DIAMETR_VALUE"])): ?>
                                <div class="catalog__item-list-item">Диаметр: <?= $basketItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_DIAMETR_VALUE"] ?></div>
                                 <? endif; ?>
                                 <? if (!empty($basketItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_DLINA_VALUE"])): ?>
                                <div class="catalog__item-list-item">Длина: <?= $basketItem["PRODUCT_INFO"]["PROPERTY_KF_DLYA_SAYTA_DLINA_VALUE"] ?></div>
                                 <? endif; ?>
                            </div>
                            <div class="catalog__item-numb"><?= $basketItem["QUANTITY"] ?> шт</div>
                            <div class="catalog__item-price">
                                <div class="catalog__item-price-now"><?= $basketItem['BASE_PRICE_FORMATED'] ?></div>
                                <? if ($basketItem["DISCOUNT_PRICE_PERCENT_FORMATED"] <> ''): ?>
                                    <div class="catalog__item-price-old"><?= $basketItem['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></div>
                                <? endif; ?>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
                <div class="cart__item-all">
                    <div class="orders__item-bt">
                        <a class="orders__item-load" href="<?= $arResult["URL_TO_COPY"] ?>">
                            Повторить заказ<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/load.svg" alt="">
                        </a>
                        <a class="orders__item-bottom" href="<?= $arResult["URL_TO_CANCEL"] ?>">
                            Отменить заказ<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/close-roud.svg" alt="">
                        </a>
                    </div>
                </div>
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
                    "ALLOW_MULTI_SELECT" => "Y",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "N",
                    "MENU_CACHE_GET_VARS" => ""
                )
            ); ?>
        </div>
    </div>
</div>
<!--sale-order-detail-general-->

<?php
$javascriptParams = array(
    "url" => CUtil::JSEscape($this->__component->GetPath() . '/ajax.php'),
    "templateFolder" => CUtil::JSEscape($templateFolder),
    "templateName" => $this->__component->GetTemplateName(),
    "paymentList" => $paymentData,
    "returnUrl" => $arResult['RETURN_URL'],
);
$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
?>
<script>
    BX.Sale.PersonalOrderComponent.PersonalOrderDetail.init(<?=$javascriptParams?>);
</script>
