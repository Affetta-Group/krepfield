<?php

IncludeModuleLangFile(__FILE__);

if ($APPLICATION->GetGroupRight("form") > "D") {
    $aMenu = array(
        "parent_menu" => "global_menu_services",
        "section" => "form",
        "sort" => 100,
        "text" => "AFFETTA",
        "title" => 'wats is das',
        "icon" => "form_menu_icon",
        "page_icon" => "form_page_icon",
        "module_id" => "affettaredirects",
        "items_id" => "menu_affettaredirects",
        "items" => array(),
    );

    $arFormsList[] = array(
        "text" => "Список редиректов",
        "dynamic" => false,
        "module_id" => "affettaredirects",
        "title" => '????',
        "items_id" => "menu_affettaredirects_list",
        "url" => "affettaredirects_info.php?lang=".LANGUAGE_ID,
//        "items" => $arFormsList,
        "more_url" => array(
            "form_result_list.php",
            "form_result_edit.php",
        )
    );

    $arFormsList[] = array(
        "text" => "Добавить редирект",
        "dynamic" => false,
        "module_id" => "affettaredirects",
        "title" => '????',
        "items_id" => "menu_affettaredirects_add",
        "url" => "affettaredirects_row_edit.php?lang=".LANGUAGE_ID,
//        "items" => $arFormsList,
        "more_url" => array(
            "form_result_list.php",
            "form_result_edit.php",
        )
    );

    $aMenu["items"][] = array(
        "text" => GetMessage("SUBMENU"),
        "dynamic" => true,
        "module_id" => "affettaredirects",
        "title" => '????',
        "items_id" => "menu_affettaredirects_list",
        "items" => $arFormsList,
        "more_url" => array(
            "form_result_list.php",
            "form_result_edit.php",
        )
    );

    return $aMenu;
}
return false;

