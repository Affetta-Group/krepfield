<?php
$replaces = [
    'SHOW_ALL'=>'bShowAll',
    'ALL_RECORDS'=>'NavShowAll',
    'REVERSED_PAGES'=>'bDescPageNumbering',
    'CURRENT_PAGE'=>'NavPageNomer',
    'PAGE_COUNT'=>'NavPageCount',
    //'URL'=>'sUrlPath',
    'START_PAGE'=>'nStartPage',
    'END_PAGE'=>'nEndPage',
    'RECORD_COUNT'=>'NavRecordCount',
    'LAST_RECORD'=>'NavLastRecordShow',
    'FIRST_RECORD'=>'NavFirstRecordShow',
    'ID'=>'NavNum',
    'URL'=>'sUrlPathParams'
];

foreach ($replaces as $from=>$to) {
    $arResult[$to] = $arResult[$from];
    if ($to === 'NavNum') {
        $arResult[$to] = str_replace('PAGEN_', '', $arResult[$to]);
    }

    if ($to === 'sUrlPathParams') {
        $arResult['sUrlPath'] = parse_url($arResult[$from], PHP_URL_PATH);
        $arResult['NavQueryString'] = parse_url($arResult[$from], PHP_URL_QUERY);
        $arResult[$to] = $arResult[$from];
        if (strpos($arResult[$to], '?') !== false) {
            $arResult[$to] .= '&';
        } else {
            $arResult[$to] .= '?';
        }
    }
}

$arResult['bSavePage'] = false;
require __DIR__.'/../../system.pagenavigation/more/template.php';