<div class="catalog-page__left">
    <div class="filter">
        <div class="filter__top-close js-filter-close"><img
                src="<?= SITE_TEMPLATE_PATH ?>/assets/images/svg/close.svg" alt=""></div>
        <div class="filter__list tw">
            <div class="filter__title-t"><?= $arResult["SECTION"]["NAME"] ?></div>
            <?
            $APPLICATION->IncludeComponent(
                "custom:catalog.section.list",
                "sections_menu_left",
                array(
                    "VIEW_MODE" => "TEXT",
                    "SHOW_PARENT_NAME" => "Y",
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "SECTION_ID" => "",
                    "SECTION_CODE" => $arResult["SECTION"]["CODE"],
                    "SECTION_URL" => "",
                    "COUNT_ELEMENTS" => "Y",
                    "TOP_DEPTH" => "1",
                    "SECTION_FIELDS" => array("SECTION_PAGE_URL", "PICTURE"),
                    "SECTION_USER_FIELDS" => "",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "FILTER_NAME" => "",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_NOTES" => "",
                    "CACHE_GROUPS" => "Y"
                )
            );
            ?>
        </div>
        <div class="filter__top-tt">Фильтр</div>
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.smart.filter",
            "main",
            array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "SECTION_ID" => $arCurSection['ID'],
                "FILTER_NAME" => "main",
                "PRICE_CODE" => $arParams["~PRICE_CODE"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "SAVE_IN_SESSION" => "N",
                "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                "XML_EXPORT" => "N",
                "SECTION_TITLE" => "NAME",
                "SECTION_DESCRIPTION" => "DESCRIPTION",
                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                "SEF_MODE" => $arParams["SEF_MODE"],
                "SEF_RULE" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["smart_filter"],
                "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
            ),
            $component,
            array('HIDE_ICONS' => 'Y')
        );
        ?>
    </div>
</div>