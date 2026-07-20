<?php if ($arResult['USEFUL']) { ?>
    <div class="cart-product__useful">
        <div class="cart-product__useful-head">
            <div class="cart-product__useful-title">
                <h2>Полезные статьи и лайфхаки</h2>
            </div>
            <div class="cart-product__useful-arrow">
                <svg><use xlink:href="#arrow"></use></svg>
            </div>
        </div>
        <div class="cart-product__useful-body hidden">
            <? foreach ($arResult['USEFUL'] as $items) {?>
                <? foreach ($items as $item) {?>
                    <div class="cart-product__useful-link">
                        <div class="cart-product__useful-text">
                            <a href="<?=$item['URL']?>"><?=$item['NAME']?></a>
                        </div>
                        <div class="cart-product__useful-textarrow">
                            <svg><use xlink:href="#arrow"></use></svg>
                        </div>
                    </div>
                <?}?>
            <?}?>
        </div>
    </div>
<?php } ?>

<div class="cart-product__links">
    <a class="cart-product__links-item active js-link" href="#descr">Описание</a>
    <a class="cart-product__links-item js-link" href="#hr">Характеристики</a>
    <?if (!empty($arResult["PRODUCTS_OTHER_SIZE"])):?>
        <a class="cart-product__links-item js-link" href="#hr2">Все размеры</a>
    <?endif;?>
    <? if (!empty($arResult["PROPERTIES"]["KNOWLEDGE_BASE"]["VALUE"])): ?>
        <a class="cart-product__links-item js-link" href="#base">База знаний</a>
    <? endif; ?>
</div>

<div class="cart-product__description">
    <div class="cart-product__description-item" id="descr">
        <h2>Описание</h2>
        <div class="cart-product__description-tx">
            <div class="cart-product__text-container">
                <?= $arResult["DETAIL_TEXT"] ?>
            </div>
        </div>
        <?if (!empty($arResult["DETAIL_TEXT"])):?>
            <div class="cart-product__description-tx-btn">
                <div class="cart-product__description-tx-btn-it op">
                    Читать больше
                    <svg>
                        <use xlink:href="#arrow3"></use>
                    </svg>
                </div>
                <div class="cart-product__description-tx-btn-it nn">
                    Скрыть
                    <svg>
                        <use xlink:href="#arrow3"></use>
                    </svg>
                </div>
            </div>
        <?endif;?>
    </div>
    <div class="cart-product__description-item" id="hr">
        <h2>Технические характеристики</h2>
        <div class="cart-product__description-list">
            <? foreach ($arResult["DISPLAY_PROPERTIES"] as $PROPERTY): ?>
                <? if (!empty($PROPERTY["VALUE"])): ?>
                    <div class="cart-product__description-list-row">
                        <div class="cart-product__description-list-item"><?= str_replace('(КФ для сайта)', '', $PROPERTY["NAME"]) ?>:
                        </div>
                        <div class="cart-product__description-list-item"><?= $PROPERTY["VALUE"] ?></div>
                    </div>
                <? endif; ?>
            <? endforeach; ?>
        </div>
    </div>
</div>

<? if (!empty($arResult["PRODUCTS_OTHER_SIZE"])): ?>
    <div class="cart-product__table" id="hr2">
        <div class="cart-product__table-top">
            <h2>Другие размеры этого товара</h2>
            <? if (!empty($arResult["LENGTHS"]) || !empty($arResult["DIAMETERS"]) || !empty($arResult["MATERIALS"])): ?>
                <a class="cart-product__table-top-cb clear-filter" href="javascript:void(0);">Сбросить
                    фильтр</a>
            <?endif;?>
        </div>
        <div class="cart-product__table-mob">
            <div class="filter">
                <div class="filter__top-tt">Фильтр по параметрам</div>
                <div class="filter__top-close js-filter-close"><img
                            src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/close.svg" alt=""></div>
                <? if (!empty($arResult["DIAMETERS"])): ?>
                    <div class="filter__item open">
                        <div class="filter__title">Диаметр</div>
                        <div class="filter__container">
                            <div class="filter__group-check dia-mob">
                                <? foreach ($arResult["DIAMETERS"] as $i => $DIAMETER): ?>
                                    <div class="filter__check">
                                        <input type="checkbox" id="chk1-<?=$i?>" name="chk2" <?= $DIAMETER ?>>
                                        <label for="chk1-<?=$i?>"><?= $DIAMETER ?></label>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        </div>
                        <? if (count($arResult["DIAMETERS"]) > 6): ?>
                            <div class="filter__title-t-btn">Еще</div>
                        <?endif;?>
                    </div>
                <?endif;?>
                <? if (!empty($arResult["LENGTHS"])): ?>
                    <div class="filter__item open">
                        <div class="filter__title">Длина</div>
                        <div class="filter__container">
                            <div class="filter__group-check len-mob">
                                <? foreach ($arResult["LENGTHS"] as $i => $LENGTH): ?>
                                    <div class="filter__check">
                                        <input type="checkbox" id="chk2-<?= $i ?>" name="chk3" value="<?= $LENGTH ?>">
                                        <label for="chk2-<?=$i?>"><?= $LENGTH ?></label>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        </div>
                        <? if (count($arResult["LENGTHS"]) > 6): ?>
                            <div class="filter__title-t-btn">Еще</div>
                        <?endif;?>
                    </div>
                <?endif;?>
                <? if (!empty($arResult["MATERIALS"])): ?>
                    <div class="filter__item open">
                        <div class="filter__title">Материал</div>
                        <div class="filter__container">
                            <div class="filter__group-check mat-mob">
                                <? foreach ($arResult["MATERIALS"] as $i => $MATERIAL): ?>
                                    <div class="filter__check">
                                        <input type="checkbox" id="chk3-<?= $i ?>" name="chk4" value="<?= $MATERIAL ?>">
                                        <label for="chk3-<?=$i?>"><?= $MATERIAL ?></label>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        </div>
                        <? if (count($arResult["MATERIALS"]) > 6): ?>
                            <div class="filter__title-t-btn">Еще</div>
                        <?endif;?>
                    </div>
                <?endif;?>
                <? if (!empty($arResult["LENGTHS"]) || !empty($arResult["DIAMETERS"]) || !empty($arResult["MATERIALS"])): ?>
                    <div class="filter__btn">
                        <a class="button button-black filter-add js-filter-close" href="javascript:void(0);">Применить</a>
                        <a class="button button-link clear-filter js-filter-close" href="javascript:void(0);">Сбросить фильтр</a>
                    </div>
                <?endif;?>
            </div>
            <? if (!empty($arResult["LENGTHS"]) || !empty($arResult["DIAMETERS"]) || !empty($arResult["MATERIALS"])): ?>
                <? if (count($arResult["DIAMETERS"]) > 1): ?>
                    <div class="select">
                        <select class="js-select dia-mob">
                            <option value="0" selected="true" disabled="disabled">Диаметр</option>
                            <?asort($arResult["DIAMETERS"], SORT_NUMERIC);?>
                            <? foreach ($arResult["DIAMETERS"] as $i => $DIAMETER): ?>
                                <option value="<?= $i++ ?>"><?= $DIAMETER ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                <? endif; ?>
                <? if (count($arResult["LENGTHS"]) > 1): ?>
                    <div class="select">
                        <select class="js-select len-mob">
                            <option value="0" selected="true" disabled="disabled">Длина</option>
                            <?asort($arResult["LENGTHS"], SORT_NUMERIC);?>
                            <? foreach ($arResult["LENGTHS"] as $i => $LENGTH): ?>
                                <option value="<?= $i++ ?>"><?= $LENGTH ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                <? endif; ?>

                <? if (count($arResult["MATERIALS"]) > 1): ?>
                    <div class="select">
                        <select class="js-select mat-mob">
                            <option value="0" selected="true" disabled="disabled">Материал</option>
                            <?asort($arResult["MATERIALS"], SORT_NUMERIC);?>
                            <? foreach ($arResult["MATERIALS"] as $i => $MATERIAL): ?>
                                <option value="<?= $i++ ?>"><?= $MATERIAL ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                <? endif; ?>

                <? if (!empty($arResult["LENGTHS"]) || !empty($arResult["DIAMETERS"]) || !empty($arResult["MATERIALS"])): ?>
                    <div class="filter__btn">
                        <a class="button button-black filter-add js-filter-close" href="javascript:void(0);">Применить</a>
                        <a class="button button-link clear-filter js-filter-close" href="javascript:void(0);">Сбросить фильтр</a>
                    </div>
                <?endif;?>
            <?endif;?>
            <?php
            $GLOBALS["arrFilter"] = array("ID" => $arResult["IDS"]);
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "main_page_sections",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "CLASS_NAME" => 'filter_products',
                    "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                    "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                    "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                    "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                    "HIDE_SECTION_DESCRIPTION" => $arParams["HIDE_SECTION_DESCRIPTION"],
                    "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                    "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                    "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                    "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                    "BASKET_URL" => $arParams["BASKET_URL"],
                    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                    "FILTER_NAME" => "arrFilter",
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "MESSAGE_404" => $arParams["MESSAGE_404"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "SHOW_404" => $arParams["SHOW_404"],
                    "FILE_404" => $arParams["FILE_404"],
                    "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                    "PAGE_ELEMENT_COUNT" => 100,
                    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                    "PRICE_CODE" => $arParams["PRICE_CODE"],
                    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                    "ADD_PROPERTIES_TO_BASKET" => ($arParams["ADD_PROPERTIES_TO_BASKET"] ?? ''),
                    "PARTIAL_PRODUCT_PROPERTIES" => ($arParams["PARTIAL_PRODUCT_PROPERTIES"] ?? ''),
                    "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

                    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],

                    "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                    "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                    "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                    "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                    "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                    "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

                    'LABEL_PROP' => $arParams['LABEL_PROP'],
                    'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                    'PRODUCT_DISPLAY_MODE' => "N",

                    'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                    'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                    'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
                    'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
                    'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
                    'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
                    'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

                    'TEMPLATE_THEME' => ($arParams['TEMPLATE_THEME'] ?? ''),
                    "ADD_SECTIONS_CHAIN" => 'N',
                    'ADD_TO_BASKET_ACTION' => $basketAction,
                    'SHOW_CLOSE_POPUP' => $arParams['COMMON_SHOW_CLOSE_POPUP'] ?? '',
                    'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
                    'SECTION_USER_FIELDS' => $arParams['SECTION_USER_FIELDS'],
                ),
                $component
            );
            unset($GLOBALS["arrFilter"]);
            ?>
            <? $count_products_other_size = count($arResult["PRODUCTS_OTHER_SIZE"]["FIELDS"]); ?>
            <a class="cart-product__table-tb-btn2"
               style="<?= $count_products_other_size <= 3 ? 'display:none;' : '' ?>" id="show_more-mob"
               href="javascript:void(0);">Показать все</a>
            <script>
                let blocks = document.querySelectorAll( ".filter_products" );
                for( let i = 0; i < blocks.length; i++){
                    if (i > 5) {
                        blocks[i].style.display = "none";
                    }
                }

                document.querySelector('#show_more-mob').addEventListener('click',function (){
                    for(let i of document.querySelectorAll('.filter_products')){
                        i.style.display = 'block';
                        document.querySelector('#show_more-mob').style.display = 'none';
                    }
                })
            </script>
        </div>
        <div class="cart-product__table-inner">
            <div class="cart-product__table-sort">
                <? if (count($arResult["MATERIALS"]) > 1): ?>
                    <div class="select">
                        <select class="js-select mat">
                            <option value="0" selected="true" disabled="disabled">Материал</option>
                            <?asort($arResult["MATERIALS"], SORT_NUMERIC);?>
                            <? foreach ($arResult["MATERIALS"] as $i => $MATERIAL): ?>
                                <option value="<?= $i++ ?>"><?= $MATERIAL ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                <? endif; ?>
                <? if (count($arResult["DIAMETERS"]) > 1): ?>
                    <div class="select">
                        <select class="js-select dia">
                            <option value="0" selected="true" disabled="disabled">Диаметр</option>
                            <?asort($arResult["DIAMETERS"], SORT_NUMERIC);?>
                            <? foreach ($arResult["DIAMETERS"] as $i => $DIAMETER): ?>
                                <option value="<?= $i++ ?>"><?= $DIAMETER ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                <? endif; ?>
                <? if (count($arResult["LENGTHS"]) > 1): ?>
                    <div class="select">
                        <select class="js-select len">
                            <option value="0" selected="true" disabled="disabled">Длина</option>
                            <?asort($arResult["LENGTHS"], SORT_NUMERIC);?>
                            <? foreach ($arResult["LENGTHS"] as $i => $LENGTH): ?>
                                <option value="<?= $i++ ?>"><?= $LENGTH ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                <? endif; ?>
                <? if ((count($arResult["MATERIALS"]) > 1) || (count($arResult["DIAMETERS"]) > 1) || (count($arResult["LENGTHS"]) > 1)): ?>
                    <div class="select">
                        <button class="button button-bord filter-add" type="submit">Применить</button>
                    </div>
                <? endif; ?>
            </div>
            <div class="cart-product__table-tb" id="tb">
                <table>
                    <thead>
                    <tr>
                        <th>Фото</th>
                        <th>Название</th>
                        <th onclick="sort(3)" style="white-space: nowrap">Диаметр<span class="sort"><img
                                        src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/tbl-arrow.svg"
                                        alt=''></span></th>
                        <th onclick="sort(4)" style="white-space: nowrap">Длина<span class="sort"><img
                                        src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/tbl-arrow.svg"
                                        alt=''></span></th>
                        <th>Материал</th>
                        <th onclick="sort(6)" style="white-space: nowrap">Упаковка<span class="sort"><img
                                        src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/tbl-arrow.svg"
                                        alt=''></span></th>
                        <th>Цена</th>
                        <th>Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($arResult["PRODUCTS_OTHER_SIZE"]["FIELDS"] as $i => $product):
                        ?>
                        <tr class="other_products"
                            data-diametr="<?= $arResult["PRODUCTS_OTHER_SIZE"]["PROPS"][$i]["KF_DLYA_SAYTA_DIAMETR"]["VALUE"] ?>"
                            data-length="<?= $arResult["PRODUCTS_OTHER_SIZE"]["PROPS"][$i]["KF_DLYA_SAYTA_DLINA"]["VALUE"] ?>"
                            data-material="<?= $arResult["PRODUCTS_OTHER_SIZE"]["PROPS"][$i]["KF_DLYA_SAYTA_MATERIAL"]["VALUE"] ?>">
                            <td>
                                <div class="cart-product__table-tb-img"><img
                                            src="<?= !empty($product["PREVIEW_PICTURE"]) ? $product["PREVIEW_PICTURE"] : SITE_TEMPLATE_PATH . "/assets/images/svg/no-img.svg" ?>"
                                            alt=''>
                                </div>
                            </td>
                            <td><a class="cart-product__table-tb-title"
                                   href="<?= $product["DETAIL_PAGE_URL"] ?>">
                                    <?= $product["PROPERTY_KF_DLYA_SAYTA_NAIMENOVANIE_VALUE"] ?>
                                </a></td>
                            <td>
                                <div class="cart-product__table-tb-numb"><?= !empty($arResult["PRODUCTS_OTHER_SIZE"]["PROPS"][$i]["KF_DLYA_SAYTA_DIAMETR"]["VALUE"]) ? $arResult["PRODUCTS_OTHER_SIZE"]["PROPS"][$i]["KF_DLYA_SAYTA_DIAMETR"]["VALUE"] : '-' ?></div>
                            </td>
                            <td>
                                <div class="cart-product__table-tb-numb"><?= !empty($arResult["PRODUCTS_OTHER_SIZE"]["PROPS"][$i]["KF_DLYA_SAYTA_DLINA"]["VALUE"]) ? $arResult["PRODUCTS_OTHER_SIZE"]["PROPS"][$i]["KF_DLYA_SAYTA_DLINA"]["VALUE"] : '-' ?></div>
                            </td>
                            <td>
                                <div class="cart-product__table-tb-numb"><?= !empty($arResult["PRODUCTS_OTHER_SIZE"]["PROPS"][$i]["KF_DLYA_SAYTA_MATERIAL"]["VALUE"]) ? $arResult["PRODUCTS_OTHER_SIZE"]["PROPS"][$i]["KF_DLYA_SAYTA_MATERIAL"]["VALUE"] : '-' ?></div>
                            </td>
                            <td>
                                <div class="cart-product__table-tb-numb"><?= !empty($arResult["PRODUCTS_OTHER_SIZE"]["PROPS"][$i]["KF_DLYA_SAYTA_KRATNOST_UPAKOVKI"]["VALUE"]) ? $arResult["PRODUCTS_OTHER_SIZE"]["PROPS"][$i]["KF_DLYA_SAYTA_KRATNOST_UPAKOVKI"]["VALUE"].' шт' : '-' ?></div>
                            </td>
                            <td>
                                <div class="cart-product__table-tb-price"><?= $arResult["PRODUCTS_OTHER_SIZE"]["PRICES"][$i]["PRICE"] ?>
                                    ₽
                                </div>
                            </td>
                            <? if ($arResult["PRODUCTS_OTHER_SIZE"]["PRICES"][$i]["PRICE"] === "0.00" || $arResult["PRODUCTS_OTHER_SIZE"]["PRICES"][$i]["PRODUCT_QUANTITY"] <= 0): ?>
                                <td><a class="cart-product__table-tb-btn"
                                       href="javascript:void(0);">нет в наличии</a></td>
                            <? else: ?>
                                <td><a class="cart-product__table-tb-btn add-basket"
                                       data-id="<?= $product['ID'] ?>"
                                       href="javascript:void(0);">В корзину</a></td>
                            <? endif; ?>
                        </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<? endif; ?>

<? if (!empty($arResult["PROPERTIES"]["KNOWLEDGE_BASE"]["VALUE"])): ?>
    <div class="blog-slider" id="base">
        <div class="blog-slider__bg">
            <h2>База знаний</h2>
            <?
            $GLOBALS['arrFilterBase'] = array("ID" => $arResult["PROPERTIES"]["KNOWLEDGE_BASE"]["VALUE"]);
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "base",
                array(
                    "DISPLAY_DATE" => "Y",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "AJAX_MODE" => "N",
                    "IBLOCK_TYPE" => "content",
                    "IBLOCK_ID" => "3",
                    "NEWS_COUNT" => "6",
                    "SORT_BY1" => "SORT",
                    "SORT_ORDER1" => "ASC",
                    "SORT_BY2" => "ID",
                    "SORT_ORDER2" => "ASC",
                    "TAGS_HIGHLOAD_ID" => "2",
                    "FILTER_NAME" => "arrFilterBase",
                    "FIELD_CODE" => array("ID"),
                    "PROPERTY_CODE" => array("DESCRIPTION"),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_LAST_MODIFIED" => "Y",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Новости",
                    "PAGER_SHOW_ALWAYS" => "Y",
                    "PAGER_TEMPLATE" => "",
                    "PAGER_DESC_NUMBERING" => "Y",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "Y",
                    "PAGER_BASE_LINK_ENABLE" => "Y",
                    "SET_STATUS_404" => "Y",
                    "SHOW_404" => "N",
                    "MESSAGE_404" => "",
                    "PAGER_BASE_LINK" => "",
                    "PAGER_PARAMS_NAME" => "arrPager",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => ""
                )
            );
            unset($GLOBALS['arrFilterBase']);
            ?>
        </div>
    </div>
<? endif; ?>

<?// if (!empty($arResult["PROPERTIES"]["KF_DLYA_SAYTA_CERTIFICATES"])): ?>
<!--    <div class="cart-product__description">-->
<!--        <div class="cart-product__description-item" id="cert" style="width: 100%">-->
<!--            <h2>Сертификаты</h2>-->
<!--            <div class="cart-product__description-list">-->
<!--                --><?// foreach ($arResult["KF_DLYA_SAYTA_CERTIFICATES"] as $CERTIFICATE): ?>
<!--                    --><?// if (!empty($CERTIFICATE["VALUE"])): ?>
<!--                        <div class="cart-product__description-list-row">-->
<!--                            <div class="cart-product__description-list-item"><a href="--><?php //=?><!--" class="link-reset" target="_blank" title="--><?php //=?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    --><?// endif; ?>
<!--                --><?// endforeach; ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?// endif; ?>
<script>
    let i = 1
    function sort(column) {
        let n = column;
        let table = document.querySelector('#tb table');
        let arr = [];
        if (document.querySelectorAll('li.disabled.selected').length === document.querySelectorAll('div.selectric-items').length) {
            document.querySelectorAll('#show_more')[0].click();
        }
        table.querySelectorAll('tr').forEach((el, index) => {
            if (index == 0) return;
            arr.push(el);
            el.remove();
        })

        arr.sort((a, b) => {
            if (i%2 === 0) {
                return b.querySelector(`td:nth-child(${n})`).innerText - a.querySelector(`td:nth-child(${n})`).innerText;
            }
            else {
                return a.querySelector(`td:nth-child(${n})`).innerText - b.querySelector(`td:nth-child(${n})`).innerText;
            }
        });

        arr.forEach((el) =>{
            table.append(el);
        })
        i++
    }

    if ($('.cart-product__text-container').height() > 365) {
        $('.cart-product__description-tx-btn').css("display", "inline-block");
    };


    const btn = document.querySelector(".cart-product__useful-head");
    const content = document.querySelector(".cart-product__useful-body");

    if (btn && content) {
        btn.addEventListener("click", btnClick);
    }

    function btnClick() {
        btn.classList.toggle("active");
        content.classList.toggle("hidden");
    }

</script>