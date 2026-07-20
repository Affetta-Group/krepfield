<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$ClientID = 'navigation_' . $arResult['NavNum'];


if (!$arResult["NavShowAlways"]) {
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false)) {
        return;
    }
}

?>
<div class="catalog-page__content-tb-bottom">
    <?
    $plus = $arResult["NavPageNomer"] + 1;
    $url = $arResult["sUrlPathParams"] . "PAGEN_" . $arResult["NavNum"] . "=" . $plus;
    ?>
    <? if ($arResult["NavPageCount"] > 1): ?>
        <? if ($arResult["NavPageNomer"] + 1 <= $arResult["nEndPage"]): ?>
            <div class="catalog-page__content-tb-bottom-btn load-more-items" data-url="<?= $url ?>">
                Показать еще
            </div>
        <? endif ?>
    <? endif ?>

    <div class="pagination-bl">
        <ul class="pagination">
            <?php
            $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
            $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");
            if ($arResult["bDescPageNumbering"] === true) {
// to show always first and last pages
                $arResult["nStartPage"] = $arResult["NavPageCount"];
                $arResult["nEndPage"] = 1;

                $sPrevHref = '';
                if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) {
                    $bPrevDisabled = false;
                    if ($arResult["bSavePage"]) {
                        $sPrevHref = $arResult["sUrlPath"] . '?' . $strNavQueryString . 'PAGEN_' . $arResult["NavNum"] . '=' . ($arResult["NavPageNomer"] + 1);
                    } else {
                        if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"] + 1)) {
                            $sPrevHref = $arResult["sUrlPath"] . $strNavQueryStringFull;
                        } else {
                            $sPrevHref = $arResult["sUrlPath"] . '?' . $strNavQueryString . 'PAGEN_' . $arResult["NavNum"] . '=' . ($arResult["NavPageNomer"] + 1);
                        }
                    }
                } else {
                    $bPrevDisabled = true;
                }

                $sNextHref = '';
                if ($arResult["NavPageNomer"] > 1) {
                    $bNextDisabled = false;
                    $sNextHref = $arResult["sUrlPath"] . '?' . $strNavQueryString . 'PAGEN_' . $arResult["NavNum"] . '=' . ($arResult["NavPageNomer"] - 1);
                } else {
                    $bNextDisabled = true;
                }

                $bFirst = true;
                $bPoints = false;
                do {
                    $NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;
                    if ($arResult["nStartPage"] < 2 || $arResult["NavPageCount"] - $arResult["nStartPage"] < 1 || abs($arResult['nStartPage'] - $arResult["NavPageNomer"]) < 2) {

                        if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                            ?>
                            <li class="active"><a href="#"><?= $NavRecordGroupPrint ?></a></li>
                        <?php
                        elseif ($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
                            ?>
                            <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= $NavRecordGroupPrint ?></a>
                        <?php
                        else:
                            ?>
                            <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"><?= $NavRecordGroupPrint ?></a>
                        <?php
                        endif;
                        $bFirst = false;
                        $bPoints = true;
                    } else {
                        if ($bPoints) {
                            ?>...<?php
                            $bPoints = false;
                        }
                    }
                    $arResult["nStartPage"]--;
                } while ($arResult["nStartPage"] >= $arResult["nEndPage"]);
            } else {
// to show always first and last pages
                $arResult["nStartPage"] = 1;
                $arResult["nEndPage"] = $arResult["NavPageCount"];

                $sPrevHref = '';
                if ($arResult["NavPageNomer"] > 1) {
                    $bPrevDisabled = false;

                    if ($arResult["bSavePage"] || $arResult["NavPageNomer"] > 2) {
                        $sPrevHref = $arResult["sUrlPath"] . '?' . $strNavQueryString . 'PAGEN_' . $arResult["NavNum"] . '=' . ($arResult["NavPageNomer"] - 1);
                    } else {
                        $sPrevHref = $arResult["sUrlPath"] . $strNavQueryStringFull;
                    }
                } else {
                    $bPrevDisabled = true;
                }

                $sNextHref = '';
                if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) {
                    $bNextDisabled = false;
                    $sNextHref = $arResult["sUrlPath"] . '?' . $strNavQueryString . 'PAGEN_' . $arResult["NavNum"] . '=' . ($arResult["NavPageNomer"] + 1);
                } else {
                    $bNextDisabled = true;
                }
                $arResult['catalogUrlPath'] = str_replace('filter/clear/apply/', '', $arResult["sUrlPath"]);
                ?>

                <?php if (!$bPrevDisabled): ?>
                    <li class="page-item prev">
                        <a class="page-link" href="<?= str_replace('filter/clear/apply/', '', $sPrevHref) ?>">
                      <span class="page-link"><span class="ar"><svg><use
                                          xlink:href="#arrow5"></use></svg></span></span>
                        </a>
                    </li>
                <?php else: ?>

                <?php endif;
                $bFirst = true;
                $bPoints = false;
                do {
                    if ($arResult["nStartPage"] < 2 || $arResult["nEndPage"] - $arResult["nStartPage"] < 1 || abs($arResult['nStartPage'] - $arResult["NavPageNomer"]) < 2) {
                        if ($arResult["nStartPage"] == $arResult["NavPageNomer"]): ?>
                            <li class="page-item active">
                                <a class="page-link" href="javascript:void(0);">
                                    <?= $arResult["nStartPage"] ?>
                                </a>
                            </li>
                        <?php elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false): ?>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?= $APPLICATION->GetCurPage() ?><?= $strNavQueryStringFull ?>">
                                    <?= $arResult["nStartPage"] ?>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?= $APPLICATION->GetCurPage() ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>">
                                    <?= $arResult["nStartPage"] ?>
                                </a>
                            </li>
                        <?php
                        endif;
                        $bFirst = false;
                        $bPoints = true;
                    } else {
                        if ($bPoints) {
                            ?>
                            <li class="page-item">
                                <span class="page-link">...</span>
                            </li>
                            <?php
                            $bPoints = false;
                        }
                    }
                    $arResult["nStartPage"]++;
                } while ($arResult["nStartPage"] <= $arResult["nEndPage"]);
            }
            ?>
            <?php if (!$bNextDisabled): ?>
                <li class="page-item next ">
                    <a class="page-link" href="<?= str_replace('filter/clear/apply/', '', $sNextHref) ?>">
                    <span class="ar"><svg><use
                                    xlink:href="#arrow5"></use></svg></span></a>
                    </a>
                </li>
            <?php else: ?>

            <?php endif; ?>
        </ul>
    </div>
</div>