<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
<?php if (!empty($arResult['SECTIONS'])): ?>
    <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <? foreach ($arResult['SECTIONS_TREE'][0]['CHILDREN'][0]['CHILDREN'] as $i => $arSection): ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $i === 0 ? 'active' : '' ?>" id="tb<?= $i ?>-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#tb<?= $i ?>"
                        type="button" role="tab" aria-controls="tb<?= $i ?>"
                        aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"><?= $arSection["NAME"] ?>
                </button>
            </li>
        <? endforeach; ?>
    </ul>

    <div class="tab-content" id="myTabContent2">
        <? foreach ($arResult['SECTIONS_TREE'][0]['CHILDREN'][0]['CHILDREN'] as $i => $arSection): ?>

            <div class="tab-pane fade <?= $i === 0 ? 'show active' : '' ?>" id="tb<?= $i ?>"
                role="tabpanel" aria-labelledby="tb<?= $i ?>-tab">

                <div class="menu__list-title-mob"><?= $arSection["NAME"] ?></div><!-- menu__list-title-mob -->

                    <?if (!empty($arSection['CHILDREN'])):?>

                        <?
                        if(count($arSection['CHILDREN']) > 12) $slise = 5; else $slise = 4;
                        ?>

                        <div class="menu__list">

                        <? while(count($arSection['CHILDREN']) > 0): ?>

                            <div class="menu__list-it">

                            <? foreach(array_slice($arSection['CHILDREN'],0,$slise) as $arSection_4): ?>

                                    <div class="menu__list-item">
                                        <a class="menu__list-item-title" href="<?= $arSection_4["SECTION_PAGE_URL"] ?>"><?= $arSection_4["NAME"] ?></a>
                                        <span class="menu__list-item-arrow"></span>

                                        <ul>
                                            <?
                                            if(!empty($arSection_4['CHILDREN'])){
                                            $limit = count($arSection_4['CHILDREN']);}else{$limit =0;}
                                            foreach ($arSection_4['CHILDREN'] as $j => $arSection_5): ?>
                                                <li <?= $j > 4 ? 'class="dn"' : '' ?>>
                                                    <a href="<?= $arSection_5["SECTION_PAGE_URL"] ?>"><?= $arSection_5["NAME"] ?></a>
                                                </li>
                                            <? endforeach; ?>
                                        </ul>

                                        <? if ($limit > 5): ?>
                                            <div class="menu__list-item-all">
                                                <span class="cl">Еще</span>
                                                <span class="op">Скрыть</span>
                                            </div><!-- menu__list-item-all -->
                                        <? endif; ?>
                                    </div> <!-- menu__list-item -->

                            <? endforeach; ?>

                            </div><!-- menu__list-it -->

                            <?
                            for ($i = 1; $i <= $slise; $i++){
                                array_shift($arSection['CHILDREN']);
                            }
                            ?>

                        <? endwhile; ?>

                        </div><!-- menu__list -->
                    <?else:?>
                        <div class="menu__list"></div>
                    <?endif;?>

                
                <!-- </div> --><!-- menu__list-title-mob --><!-- лишний див ломал все -->


            </div><!-- tab-pane fade -->

        <? endforeach; ?>
    </div><!-- tab-content -->
<?php endif; ?>
