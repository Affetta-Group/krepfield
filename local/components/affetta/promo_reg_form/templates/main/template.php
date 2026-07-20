<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @var array $arResult
 */
?>
<div class="enter">
    <div class="container">
        <div class="enter__inner">
            <div class="enter__item enter__item-code" id="promoform">
                <div class="enter__item-title enter__item-title-code"><?=$arParams['FORM_NAME']?></div>

                <div id="promoform-inputs">
                    <div class="promoform-inputs">
                        <? foreach ($arParams['FIELDS'] as $item) {
                            switch ($item['type']){
                                case 'text':
                                    ?>
                                    <div class="enter__row">
                                        <div class="enter__input">
                                            <input id="<?=$item['name']?>" class="<?=$item['class']?>" type="<?=$item['type']?>" name="<?=$item['name']?>" placeholder="<?=$item['placeholder']?>" <?=($item['required']?' required':'')?>>
                                            <div class="enter__input-error-svg"></div>
                                            <div class="enter__input-error">
                                                Это поле обязательно<br> для заполнения
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                    break;

                                case 'checkbox':
                                    ?>
                                    <div class="enter__row">
                                        <div class="enter__input">
                                            <div class="enter__checkbox-cont custom-checkbox">
                                                <input id="<?=$item['name']?>" class="<?=$item['class']?>" type="<?=$item['type']?>" name="<?=$item['name']?>" <?=($item['required']?' required':'')?>>
                                                <label for="<?=$item['name']?>"><?=$item['placeholder']?></label>
                                            </div>
                                            <div class="enter__input-error-svg"></div>
                                            <div class="enter__input-error">
                                                Это поле обязательно<br> для заполнения
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                    break;

                                case 'select':

                                    ?>
                                    <div class="enter__row">
                                        <div class="dropdown enter__input">
                                            <button class="dropdown__button" type="button">
                                                <?=$item['placeholder']?>
                                                <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/svg/sprite.svg#simplearrow"></use></svg>
                                            </button>
                                            <ul class="dropdown__list">
                                                <?foreach ($item['ext'] as $subitem):?>
                                                    <li class="dropdown__list-item" data-value="<?=$subitem['name']?>"><?=$subitem['placeholder']?></li>
                                                <?endforeach;?>
                                            </ul>
                                            <input class="dropdown__input_hidden" type="text" name="select-category" id="<?=$item['name']?>" value=""/>
                                            <div class="enter__input-error-svg"></div>
                                            <div class="enter__input-error">
                                                Это поле обязательно<br> для заполнения
                                            </div>
                                        </div>
                                    </div>
                                    <?

                                    break;

                                case 'multiselect_ext':

                                    ?>
                                    <div class="enter__row">
                                        <div class="dropdown_with-chk enter__input" id="<?=$item['name']?>">
                                            <button class="dropdown_with-chk__button" type="button">
                                                <?=$item['placeholder']?>
                                                <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/svg/sprite.svg#simplearrow"></use></svg>
                                            </button>
                                            <ul class="dropdown_with-chk__list">
                                                <?foreach ($item['ext'] as $subitem):?>
                                                    <li class="dropdown_with-chk__list-item custom-checkbox">
                                                        <input class="dropdown_with-chk__list-item_label" type="checkbox" name="<?=$subitem['name']?>" id="<?=$subitem['name']?>"/>
                                                        <label class="dropdown_with-chk__list-item_label" for="<?=$subitem['name']?>"><?=$subitem['placeholder']?></label>
                                                    </li>
                                                <?endforeach;?>
                                            </ul>
                                            <div class="enter__input-error-svg"></div>
                                            <div class="enter__input-error">
                                                Это поле обязательно<br> для заполнения
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                    break;
                            }
                        } ?>

                        <input hidden name="utm_source" value="<?=$_GET['utm_source']?>">
                        <input hidden name="utm_campaign" value="<?=$_GET['utm_campaign']?>">

                    </div>
                </div>

                <div class="enter__error-text"></div>

                <button class="button button-black" id="send_code" type="submit">Зарегистрироваться</button>
                <button class="button button-black" style="display: none" id="sign_in" type="submit">Войти</button>

                <div class="enter__reg <?=($arParams['SHOW_PROMO_LINK'] == 'Y' ? '' : 'enter__reg-center')?>">
                    <?if($arParams['SHOW_PROMO_LINK'] == 'Y'):?>
                        <div>
                            <a href="/promo/" class="enter__reg-link">Регистрация для специалистов</a>
                        </div>
                    <?endif;?>
                    <?if($arParams['SHOW_AUTH_LINK'] == 'Y'):?>
                        <div>
                            <span class="enter__reg-label">Уже есть аккаунт?</span>
                            <a href="/auth/" class="enter__reg-link">Войти</a>
                        </div>
                    <?endif;?>
                </div>

                <?if($arParams['SHOW_PROMO_LINK'] != 'Y'):?>
                    <div style="text-align: center;">
                        <img style="width:100%;padding-top:20px;" src="<?=SITE_TEMPLATE_PATH?>/assets/images/youdo.png">
                    </div>
                <?endif;?>

            </div>
            <div class="enter__item enter__item-no-padding">
                <img src="<?=SITE_TEMPLATE_PATH?>/assets/images/authForm.png">
            </div>
        </div>
    </div>
</div>
<?php
$jsParams = [
    "params" => $arParams,
];
?>
<script type="application/javascript">
    var promoReg = new promoReg(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>
