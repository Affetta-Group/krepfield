<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$ids = $_POST['ids'];
$result = array();
foreach ($ids[array_key_first($ids)]['goods'] as &$item) {
    if ($item['id']) {
        $arFilter = array('IBLOCK_ID' => 10, 'ACTIVE'=>"Y", 'ID'=>$item['id']);
        $arSelect = array('IBLOCK_ID', 'ID', 'NAME','CODE','PREVIEW_PICTURE');
        $rsSect = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);

        while ($arSect = $rsSect->GetNext()) {
            $arSect['PREVIEW_PICTURE'] = $arSect['PREVIEW_PICTURE'] ? AffettaCFile::ResizeImageGet(['FILE_NAME_NEW' => $arSect['CODE']], $arSect['PREVIEW_PICTURE'], ["width" => 327, "height" => 332 ])['SRC'] : SITE_TEMPLATE_PATH . '/assets/images/svg/no-img.svg' ;
            $item['name'] = $arSect['NAME'];
            $item['code'] = $arSect['CODE'];
            $item['picture'] = $arSect['PREVIEW_PICTURE'];}
    }
}

if ($ids) {
    echo json_encode($ids);
} else {
    $result['status'] = 'error';
}