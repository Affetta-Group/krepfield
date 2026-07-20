<?php

class Tags extends CBitrixComponent
{
    public function executeComponent()
    {
        global $APPLICATION;

        if($this->arParams['DEV'] == 'Y' && $_GET['d'] != 'y') return;

        if(!isset($GLOBALS['AF_TAGS'])) {
            $arFilter = array('IBLOCK_ID' => $this->arParams['IBLOCK_ID'], 'ID' => $this->arParams['SECTION_ID']);
            $db_list = CIBlockSection::GetList(array("SORT" => "ASC"), $arFilter, true, [$this->arParams['TOP'], $this->arParams['BOTTOM'], "UF_BANNER", "UF_BANNER_LINK"]);
            if ($ar_result = $db_list->GetNext()) {
                global $USER;
                $GLOBALS['AF_TAGS'][$this->arParams['TOP']] = $ar_result['~'.$this->arParams['TOP']];
                $GLOBALS['AF_TAGS'][$this->arParams['BOTTOM']] = $ar_result['~'.$this->arParams['BOTTOM']];

                $this->arResult['AF_TAGS'][$this->arParams['TOP']] = $ar_result['~'.$this->arParams['TOP']];
                $this->arResult['AF_TAGS'][$this->arParams['BOTTOM']] = $ar_result['~'.$this->arParams['BOTTOM']];
                $this->arResult['AF_BANNER'] = CFile::ResizeImageGet($ar_result['~UF_BANNER'], array('width' => 3000, 'height' => 3000))["src"];
                $this->arResult['AF_BANNER_LINK'] = $ar_result['~UF_BANNER_LINK'];
            }

            $APPLICATION->SetAdditionalCSS($this->getPath()."/style1.css");
            $APPLICATION->AddHeadScript($this->getPath()."/script1.js");
        } else {
            $this->arResult['AF_TAGS'][$this->arParams['TOP']] = $GLOBALS['AF_TAGS'][$this->arParams['TOP']];
            $this->arResult['AF_TAGS'][$this->arParams['BOTTOM']] = $GLOBALS['AF_TAGS'][$this->arParams['BOTTOM']];
            $this->arResult['AF_BANNER'] = CFile::ResizeImageGet($ar_result['~UF_BANNER'], array('width' => 3000, 'height' => 3000))["src"];
            $this->arResult['AF_BANNER_LINK'] = $ar_result['~UF_BANNER_LINK'];
        }

        if (!empty($GLOBALS['AF_TAGS'][$this->arParams['DISPLAY_TYPE']]) || $this->arResult['AF_BANNER']){
            $this->includeComponentTemplate();
        }
    }
}