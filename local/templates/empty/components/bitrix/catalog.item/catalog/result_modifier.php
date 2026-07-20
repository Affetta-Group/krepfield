<?

$arResult['ITEM']['PROPERTIES'] = array();
$arResult['ITEM']["PRICES"] = CCatalogProduct::GetOptimalPrice($arResult['ITEM']['ID']);

// $arResult['ITEM']['PREVIEW_PICTURE'] = AffettaCFile::ResizeImageGet($arResult['ITEM']['PREVIEW_PICTURE']['ID'], ["width" => 327, "height" => 332 ], false,false,false,false,['FILE_NAME_NEW' => $arResult['ITEM']['CODE']]);
 
$arResult['ITEM']['PREVIEW_PICTURE'] = CFile::ResizeImageGet($arResult['ITEM']['PREVIEW_PICTURE']['ID'], ["width" => 327, "height" => 332 ], false,false,false,false);

