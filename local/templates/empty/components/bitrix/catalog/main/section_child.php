<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $arCurSection
 */

?>
<div class="catalog-page">
    <div class="container">
        <div class="catalog-page__inner">

            <? include('includes/filter.php'); ?>

            <div class="catalog-page__content">
                <? include('includes/section_list.php'); ?>
                <div class="section-container">
                    <?
                    $arFilter = array('SECTION_ID' => $arCurSection, 'ACTIVE' => "Y");
                    $rsSect = CIBlockSection::GetList(Array("SORT"=>"ASC"),$arFilter, false, array());
                    while ($arSect = $rsSect->GetNext()) {?>
                        <? if (!empty($arSect['PICTURE'])) {
                            $src = CFile::ResizeImageGet($arSect['PICTURE'], ["width" => 50, "height" => 50 ], false,false,false,false)['src']; ?>
                            <!-- $src = AffettaCFile::ResizeImageGet($arSect['PICTURE'], ["width" => 50, "height" => 50 ], false,false,false,false,['FILE_NAME_NEW' => $arSect['NAME']])['src']; ?> -->
                            <a class="test-cl" href="<?=$arSect['SECTION_PAGE_URL']?>">
                                <div class="section-imgcontainer"><?if($arSect['PICTURE']) {?><img src="<?=$src?>"><?}?></div><div class="section-container_name"><?=$arSect['NAME']?></div>
                            </a>
                        <?}?>
                    <?}?>
                </div>

                <?php
              
                $APPLICATION->IncludeComponent(
                    "custom:tags",
                    "top",
                    array(
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "SECTION_ID" => $arCurSection['ID'],
                        "DEV" => 'n',
                        "DISPLAY_TYPE" => 'UF_TAGS_TOP',
                        "TOP" => 'UF_TAGS_TOP',
                        "BOTTOM" => 'UF_TAGS_BOTTOM',
                    ),
                );
                ?>

                <? include('includes/sort_line.php'); ?>

                <? include('includes/catalog_section.php'); ?>

                <?php
                $APPLICATION->IncludeComponent(
                    "custom:tags",
                    "bottom",
                    array(
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "SECTION_ID" => $arCurSection['ID'],
                        "DEV" => 'n',
                        "DISPLAY_TYPE" => 'UF_TAGS_BOTTOM',
                        "TOP" => 'UF_TAGS_TOP',
                        "BOTTOM" => 'UF_TAGS_BOTTOM',
                    ),
                );
                ?>
                <? if (strlen($GLOBALS['SEO_TEXT_HTML']) > 5 && !strpos($_SERVER['REQUEST_URI'], '?PAGEN')) {?>
                    <div class="catalog-tx text-af" data-more-text="main">
                        <?=$GLOBALS['SEO_TEXT_HTML']?>
                        <span class="button button-more button-primary" data-more-text="btn">
                            <span class="button__name" data-more-text="btn-name">Показать еще</span>
                            <svg>
                                <use xlink:href="#arrow"></use>
                            </svg>
                        </span>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
</div>

<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/advantage.php", Array(), Array("SHOW_BORDER"=>false));?>