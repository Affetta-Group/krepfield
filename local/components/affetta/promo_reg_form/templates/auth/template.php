<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @var array $arResult
 */
?>
    <div class="enter__item enter__item-code" id="promoform">
        <div class="enter__item-title enter__item-title-code"><?=$arParams['FORM_NAME']?></div>

        <div id="promoform-inputs">
            <input class="enter__item-field phone-mask" type="text" id="PHONE" name="PHONE" placeholder="+7(___) --- -- --">
        </div>

        <div class="enter__error-text"></div>

        <button class="button button-black" id="send_code" type="submit">Получить код из SMS</button>
        <button class="button button-black" style="display: none" id="sign_in" type="submit">Войти</button>

        <div class="enter__row-label-wr">
            <div class="enter__row-label">
                <span class="enter__row-label-text">Или войдите с помощью</span>
            </div>
        </div>

            <?
            $arResult["AUTH_SERVICES"] = false;
            if (CModule::IncludeModule("socialservices")) {
                $oAuthManager = new CSocServAuthManager();
                $arServices = $oAuthManager->GetActiveAuthServices($arResult);
                if (!empty($arServices)) $arResult["AUTH_SERVICES"] = $arServices;
            }
            $APPLICATION->IncludeComponent("bitrix:socserv.auth.form",
                "icons",
                array(
                    "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
                    "SUFFIX" => "form",
                ),
                false,
                array("HIDE_ICONS" => "Y")
            ); ?>
            <? if ($arResult["AUTH_SERVICES"]): ?>
                <?
                $APPLICATION->IncludeComponent("bitrix:socserv.auth.form",
                    "",
                    array(
                        "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
                        "AUTH_URL" => $arResult["AUTH_URL"],
                        "POST" => $arResult["POST"],
                        "POPUP" => "Y",
                        "SUFFIX" => "form",
                    ),
                    false,
                    array("HIDE_ICONS" => "Y")
                );
                ?>
            <? endif ?>

        <?if($arParams['SHOW_LINK'] == 'Y'):?>

            <div class="enter__reg center">
                <span class="enter__reg-label">Нет аккаунта?</span>
                <a href="/register/" class="enter__reg-link">Зарегистрируйтесь</a>
            </div>

        <?endif;?>
    </div>
    <div class="enter__item enter__item-no-padding">
        <img src="<?=SITE_TEMPLATE_PATH?>/assets/images/authForm.png">
    </div>
<?php
$jsParams = [
    "params" => $arParams,
];
?>
<script type="application/javascript">
    var promoReg = new promoReg(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>
