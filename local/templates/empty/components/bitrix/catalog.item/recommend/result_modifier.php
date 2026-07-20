<?

$arResult['ITEM']['PROPERTIES'] = array();
$arResult['ITEM']["PRICES"] = CCatalogProduct::GetOptimalPrice($arResult['ITEM']['ID']);

// $arResult['ITEM']['PREVIEW_PICTURE']['src'] = AffettaCFile::ResizeImageGet($arResult['ITEM']['PREVIEW_PICTURE']['ID'], ["width" => 170, "height" => 130], false,false,false,false,['FILE_NAME_NEW' => $arResult['ITEM']["NAME"]])['src'];
$arResult['ITEM']['PREVIEW_PICTURE']['src'] = CFile::ResizeImageGet($arResult['ITEM']['PREVIEW_PICTURE']['ID'], ["width" => 170, "height" => 130], false,false,false,false)['src'];
