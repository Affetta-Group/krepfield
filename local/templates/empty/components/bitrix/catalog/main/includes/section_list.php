<div class="catalog-main">
    <?
    $APPLICATION->IncludeComponent(
        "custom:catalog.section.list",
        "catalog_main",
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
            "ADD_SECTIONS_CHAIN" => "N",
            "FILTER_NAME" => "",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_NOTES" => "",
            "CACHE_GROUPS" => "Y"
        )
    );
    ?>
</div>