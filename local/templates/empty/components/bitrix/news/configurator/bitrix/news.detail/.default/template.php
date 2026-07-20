<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */


$this->setFrameMode(true);
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
                <h1><?= $arResult["NAME"] ?></h1>
            </div>
        </div>
    </div>
    <div class="container">
<div class="quiz-columns">
    <div class="quiz">
        <form action="">
        <?  $qNum = 0;
            for ($i = 1; $i <= 10; $i++) {
                $Question = 'QUESTION_'.$i;
                $Reply = 'REPLY_'.$i;
                $Id = 'ITEM_ID_'.$i;
                $Quan = 'ITEM_QUAN_'.$i;
                $QuanRule = 'QUAN_RULE_'.$i;
                $QuanRuleReply = 'QUAN_RULE_REPLY_'.$i;
                $RRule = 'RRULE_'.$i;
                ?>
                <? if ($arResult['PROPERTIES'][$Question]['VALUE']) {?>
                    <div class="quiz__question<?= in_array($i, $arResult['SUB_QUESTIONS']) ? " subquestion hide" : ''?>" data-question="<?=$i?>">
    <!--                                    <div class="quiz__question-title">Вопрос --><?php //=$i?><!--</div>-->
                        <div class="quiz__question-fields<?=$arResult['PROPERTIES'][$QuanRule]['VALUE'] ? ' noactive rule'.$arResult['PROPERTIES'][$QuanRule]['VALUE'] : '' ?>">
                            <div class="quiz__question-fields-title"><?=$arResult['PROPERTIES'][$Question]['VALUE']?></div>
                            <? foreach ($arResult['PROPERTIES'][$Reply]['VALUE'] as $k => $Rpl) {
                                $arId = explode(",", str_replace(' ', '', $arResult['PROPERTIES'][$Id]['VALUE'][$k]));
                                $arQuan = explode(",", str_replace(' ', '', $arResult['PROPERTIES'][$Quan]['VALUE'][$k]));
                                $arRrule = $arResult['PROPERTIES'][$RRule]['VALUE'][$k];
                                if (count($arQuan) != count($arId) || !$arQuan[0]) {
                                    $arQuan = [];
                                }
                                while (count($arQuan) < count($arId)) {
                                    $arQuan[] = 1;
                                }
                                $arIds = [];
                                foreach ($arId as $n => $value) {
                                    $arIds['goods'][$n]['id'] = $value;
                                }
                                foreach ($arQuan as $n => $value) {
                                    $arIds['goods'][$n]['quantity'] = $value;
                                }
                                foreach ($arQuan as $n => $value) {
                                    $arIds['goods'][$n]['quantity'] = $value;
                                }

                                $arIds['quanRule'] = $arResult['PROPERTIES'][$QuanRule]['VALUE'];
                                $arIds['quanRuleReply'] = $arResult['PROPERTIES'][$QuanRuleReply]['VALUE'] ? $arResult['PROPERTIES'][$QuanRuleReply]['VALUE'] - 1 : '';
                                $arIds['replyrule'] = $arRrule;
                                $arQuest = array($i => $arIds);
                                $qNum++;?>
                                <div class="quiz__question-label" data-reply="<?=$k+1?>">
                                    <label for="qq<?=$qNum?>" onchange="select_reply(<?=htmlspecialchars(json_encode($arQuest))?>)">
                                        <input type="radio" name="qqg<?=$i?>" id="qq<?=$qNum?>" autocomplete="off"<?=$arResult['PROPERTIES'][$QuanRule]['VALUE'] ? ' disabled' : '' ?>>
                                        <span><?=$Rpl?></span>
    <!--                                                    <div class="quiz__question-label-list">-->
    <!--                                                    </div>-->
                                    </label>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                <? } else break;?>
        <? } ?>
        </form>
    </div>
    <div class="quiz__result">
        <div class="quiz__result-wrapper sticky-top">
            <div class="quiz__result-title">
                <strong>Выбранные товары</strong>
                <div class="quiz__result-navigation">
                    <div class="quiz__result-prev">
                        <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.801617 6.53033C0.508723 6.23744 0.508723 5.76256 0.801617 5.46967L5.57459 0.696699C5.86748 0.403806 6.34235 0.403806 6.63525 0.696699C6.92814 0.989593 6.92814 1.46447 6.63525 1.75736L2.39261 6L6.63525 10.2426C6.92814 10.5355 6.92814 11.0104 6.63525 11.3033C6.34235 11.5962 5.86748 11.5962 5.57459 11.3033L0.801617 6.53033ZM11 6.75L1.33195 6.75V5.25L11 5.25V6.75Z"/>
                        </svg>
                    </div>
                    <div class="quiz__result-next">
                        <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.1984 6.53033C10.4913 6.23744 10.4913 5.76256 10.1984 5.46967L5.42541 0.696699C5.13252 0.403806 4.65765 0.403806 4.36475 0.696699C4.07186 0.989593 4.07186 1.46447 4.36475 1.75736L8.60739 6L4.36475 10.2426C4.07186 10.5355 4.07186 11.0104 4.36475 11.3033C4.65765 11.5962 5.13252 11.5962 5.42541 11.3033L10.1984 6.53033ZM0 6.75L9.66805 6.75V5.25L0 5.25L0 6.75Z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="slick-quiz">
            </div>
            <div class="loader hide">
                <div class="item-1"></div>
                <div class="item-2"></div>
                <div class="item-3"></div>
                <div class="item-4"></div>
                <div class="item-5"></div>
            </div>
        </div>
    </div>
</div>
</div>