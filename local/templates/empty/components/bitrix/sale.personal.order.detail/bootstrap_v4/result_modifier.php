<?php

foreach ($arResult['BASKET'] as &$arItem) {
    $db_products = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        array("ID" => $arItem["PRODUCT_ID"]),
        false,
        false,
        array("ID", "IBLOCK_ID", "PREVIEW_PICTURE", "PROPERTY_CML2_ARTICLE", "PROPERTY_KF_DLYA_SAYTA_NAIMENOVANIE", "PROPERTY_KF_DLYA_SAYTA_DIAMETR", "PROPERTY_KF_DLYA_SAYTA_DLINA", "PROPERTY_KF_DLYA_SAYTA_MATERIAL", "PROPERTY_KF_DLYA_SAYTA_KRATNOST_UPAKOVKI")
    );

    if ($db_product = $db_products->GetNext()) {
        $db_product["PREVIEW_PICTURE"] = CFile::ResizeImageGet($db_product["PREVIEW_PICTURE"], array("width" => "200", "height" => "200"));
        $arItem["PRODUCT_INFO"] = $db_product;
    }
}