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

use  Bitrix\Main\Grid\Declension;

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
<div class="article">
    <div class="container">
        <div class="article__inner">
            <div class="article__about">
                <div class="article__tx">
                    <? if (!empty($arResult["DETAIL_PICTURE"])): ?>
                        <div class="article__tx-img"
                             style="background-image: url('<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>')"></div>
                    <? endif; ?>

                    <div class="article__tx-info">
                        <? if (!empty($arResult["PROPERTIES"]["READING_TIME"]["VALUE"])): ?>
                            <span class="article__tx-time">
                                <span class="article__tx-text">На чтение</span>
                                <?= $arResult["PROPERTIES"]["READING_TIME"]["VALUE"] ?>
                            </span>
                        <? endif; ?>
                        <? if (!empty($arResult['SHOW_COUNTER'])): ?>
                            <span class="article__tx-view">
                                <span class="article__tx-text">Просмотров</span>
                                <?= $arResult['SHOW_COUNTER'] ?>
                            </span>
                        <? endif; ?>
                        <? if (!empty($arResult["DISPLAY_ACTIVE_FROM"])): ?>
                            <span class="article__tx-actfrom">
                                <span class="article__tx-text">Опублковано</span>
                                <?= $arResult["DISPLAY_ACTIVE_FROM"] ?>
                            </span>
                        <? endif; ?>
                    </div>
                    <div class="article__tx-table"></div>
                    <?= $arResult["DETAIL_TEXT"] ?>
                    <? if (!empty($arResult["PROPERTIES"]["VIDEO"]["VALUE"])): ?>
                        <h3>Видеоматериалы</h3>
                        <a class="article__tx-video" href="<?= $arResult["PROPERTIES"]["VIDEO"]["VALUE"] ?>"
                           data-fancybox
                           style="background-image: url('<?= CFile::GetPath($arResult["PROPERTIES"]["PREVIEW_VIDEO"]["VALUE"]) ?>')"></a>
                    <? endif; ?>
                </div>
            </div>
            <div class="article__right">
                <div class="article__right-inner">
                    <? if (!empty($arResult["AUTHOR"]["UF_NAME"])): ?>
                        <div class="article__author">
                            <div class="article__author-img">
                                <img src="<?= CFile::GetPath($arResult["AUTHOR"]["UF_PHOTO"]) ?>" alt="">
                            </div>
                            <div class="article__author-title">Автор</div>
                            <div class="article__author-name"><?= $arResult["AUTHOR"]["UF_NAME"] ?></div>
                            <a class="article__author-numb"
                               href="javascript:void(0);"><?= $arResult["AUTHOR"]["COUNT_ARTICLE"] ?> <?= (new Declension('статья', 'статьи', 'статей'))->get($arResult["AUTHOR"]["COUNT_ARTICLE"]) ?></a>
                        </div>
                    <? endif; ?>
                    <? if (!empty($arResult["AUTHOR"]["ARTICLE"])): ?>
                        <div class="article__other">
                            <div class="article__other-title">Другие статьи</div>
                            <div class="article__other-group">
                                <? for ($i = 0; $i < 3; $i++): ?>
                                    <a class="article__other-link"
                                       href="<?= $arResult["AUTHOR"]["ARTICLE"][$i]["DETAIL_PAGE_URL"] ?>"><?= $arResult["AUTHOR"]["ARTICLE"][$i]["NAME"] ?></a>
                                <? endfor; ?>
                            </div>
                        </div>
                    <? endif; ?>
                    <? if (!empty($arResult["TAGS"])): ?>
                        <div class="article__tags">
                            <div class="article__tags-tt">#</div>
                            <? foreach ($arResult["TAGS"] as $tag): ?>
                                <a class="article__tags-link"
                                   href="<?= SITE_DIR ?>knowledge-base/?tag=<?= $tag["UF_XML_ID"] ?>"><?= ltrim($tag["UF_NAME"], '#') ?></a>
                            <? endforeach; ?>
                        </div>
                    <? endif; ?>
                </div>
                <div class="article__soc">
                    <div class="article__soc-title"> Поделиться статьей</div>
                    <ul>
                        <li><a href="javascript:void(0);"
                               onClick="window.open('https://vkontakte.ru/share.php?url=<?= $_SERVER['HTTP_HOST'] ?><?= $APPLICATION->GetCurPage() ?>','sharer','status=0,toolbar=0,width=650,height=500');">
                                <svg>
                                    <use xlink:href="#soc1"></use>
                                </svg>
                            </a></li>
                        <li><a href="javascript:void(0);"
                               onClick="window.open('https://connect.ok.ru/offer?url=<?= $_SERVER['HTTP_HOST'] ?><?= $APPLICATION->GetCurPage() ?>','Поделиться в Одноклассниках','width=420,height=230,resizable=yes,scrollbars=yes,status=yes');">
                                <svg>
                                    <use xlink:href="#soc4"></use>
                                </svg>
                            </a></li>
                        <li><a href="javascript:void(0);"
                               onClick="window.open('https://twitter.com/intent/tweet?text=<?= $_SERVER['HTTP_HOST'] ?><?= $APPLICATION->GetCurPage() ?>','sharer','status=0,toolbar=0,width=650,height=500');">
                                <svg>
                                    <use xlink:href="#soc5"></use>
                                </svg>
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($arResult['PROPERTIES']['PRODUCTS']['VALUE'])):?>
<div class="catalog-slider tw">
    <div class="container">
        <div class="catalog-slider__bg">
            <h2>Сопутствующие товары</h2>
            <?php
            $GLOBALS["arrFilter"] = array("ID" => $arResult['PROPERTIES']['PRODUCTS']['VALUE']);
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "recommend",
                array(
                    "IBLOCK_ID" => "10",
                    "IBLOCK_TYPE" => "1c_catalog",
                    "IBLOCK_SECTION_ID" => "",
                    "FILTER_NAME" => "arrFilter",
                    "HIDE_NOT_AVAILABLE" => "Y",
                    "PRICE_CODE" => array(
                        0 => "РРЦ",
                    ),
                    "ELEMENT_SORT_FIELD" => "sort",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "PAGE_ELEMENT_COUNT" => "20",
                    "LINE_ELEMENT_COUNT" => "20",
                    "PROPERTY_CODE" => array("SHIRINA_1"),
                    "OFFERS_LIMIT" => "0",
                    "SECTION_URL" => "",
                    "DETAIL_URL" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_GROUPS" => "Y",
                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "SET_STATUS_404" => "N",
                    "CACHE_FILTER" => "N",
                    "ACTION_VARIABLE" => "action",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "USE_PRICE_COUNT" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "PRICE_VAT_INCLUDE" => "Y",
                    "CONVERT_CURRENCY" => "N",
                    "BASKET_URL" => "/personal/basket.php",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRODUCT_PROPERTIES" => array(),
                    "DISPLAY_COMPARE" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Товары",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                ),
                false
            );
            unset($GLOBALS["arrFilter"]); ?>
        </div>
    </div>
</div>
<?php endif;?>
<div class="blog-slider">
    <div class="container">
        <div class="blog-slider__bg">
            <h2>База знаний</h2>
            <?
            $GLOBALS['arrFilter'] = array("!ID" => $arResult["ID"]);
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "base",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "TAGS_HIGHLOAD_ID" => $arParams["TAGS_HIGHLOAD_ID"],
                    "NEWS_COUNT" => $arParams["NEWS_COUNT"],
                    "SORT_BY1" => "RAND",
                    "SORT_ORDER1" => "RAND",
                    "SORT_BY2" => $arParams["SORT_BY2"],
                    "SORT_ORDER2" => $arParams["SORT_ORDER2"],
                    "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
                    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                    "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
                    "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                    "IBLOCK_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
                    "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                    "MESSAGE_404" => $arParams["MESSAGE_404"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "SHOW_404" => $arParams["SHOW_404"],
                    "FILE_404" => $arParams["FILE_404"],
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
                    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
                    "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
                    "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
                    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
                    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
                    "FILTER_NAME" => "arrFilter",
                    "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                    "CHECK_DATES" => $arParams["CHECK_DATES"],
                ),
                $component
            );
            unset($GLOBALS['arrFilter']);
            ?>
        </div>
    </div>
</div>

<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/advantage.php", Array(), Array("SHOW_BORDER"=>false));?>

<script>
    const article = document.querySelector('.article__tx')
    if (article.querySelectorAll('h2, h3, h4').length) {
        const headers = [];
        const indexes = [0];
        // функция для получения предыдущего header
        const getPrevHeader = (diff = 0) => {
            if ((indexes.length - diff) === 0) {
                return null;
            }
            let header = headers[indexes[0]];
            for (let i = 1, length = indexes.length - diff; i < length; i++) {
                header = header.contains[indexes[i]];
            }
            return header;
        }
        // функция для добавления item в headers
        const addItemToHeaders = (el, diff) => {
            let header = headers;
            if (diff === 0) {
                header = indexes.length > 1 ? getPrevHeader(1).contains : header;
                indexes.length > 1 ? indexes[indexes.length - 1]++ : indexes[0]++;
            } else if (diff > 0) {
                header = getPrevHeader().contains;
                indexes.push(0);
            } else if (diff < 0) {
                const parentHeader = getPrevHeader(Math.abs(diff) + 1);
                for (let i = 0; i < Math.abs(diff); i++) {
                    indexes.pop();
                }
                header = parentHeader ? parentHeader.contains : header;
                parentHeader ? indexes[indexes.length - 1]++ : indexes[0]++;
            }
            header.push({ el, contains: [] });
        }
        // добавим заголовки в headers
        article.querySelectorAll('h2, h3, h4').forEach((el, index) => {
            if (!el.id) {
                el.id = `id-${index}`;
            }
            if (!index) {
                addItemToHeaders(el);
                return;
            }
            const diff = el.tagName.substring(1) - getPrevHeader().el.tagName.substring(1);
            addItemToHeaders(el, diff);
        });
        // сформируем оглавление страницы для вставки его на страницу
        let html = '';
        const createTableOfContents = (items) => {
            html += '<ol>';
            for (let i = 0, length = items.length; i < length; i++) {
                const url = `${location.href.split('#')[0]}#${items[i].el.id}`;
                html += `<li><a class="article__tx-table-link" href="${url}">${items[i].el.textContent}</a>`;
                if (items[i].contains.length) {
                    createTableOfContents(items[i].contains);
                }
                html += '</li>';
            }
            html += '</ol>';
        }
        createTableOfContents(headers);
        html = `<section class="table-of-contents"><div class="article__tx-table-header">Содержание: <svg><use xlink:href="#arrow"></use></svg></div><div class="article__tx-table-content hidden">${html}</div></section>`;
        // вставим оглавление в тег <aside>
        document.querySelector('.article__tx-table').insertAdjacentHTML('afterbegin', html);
    }

    const btn = document.querySelector(".article__tx-table-header");
    const content = document.querySelector(".article__tx-table-content");

    btn.addEventListener("click", btnClick);

    function btnClick() {
        btn.classList.toggle("active");
        content.classList.toggle("hidden");
    }
</script>