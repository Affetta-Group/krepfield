<?php
/**
 * @var global $mid - module id
 * @var global $APPLICATION
 * @var global $Update - if post method save
 * @var global $RestoreDefaults - if post method restoreDefaults
 */

use Bitrix\Main\Loader;
use \Bitrix\Main\Application;

Loader::includeModule('affettapromo');   //инитит классы типа CAffettaseo
IncludeModuleLangFile(__FILE__);

//user rigths for buttons
$FORM_RIGHT = $APPLICATION->GetGroupRight($mid);

//if request method restore
//require before option list
if ($_SERVER['REQUEST_METHOD'] == "GET" && CAffettapromo::IsAdmin() && $RestoreDefaults <> '' && check_bitrix_sessid())
{
    COption::RemoveOption($mid);
    $z = CGroup::GetList("", "", array("ACTIVE" => "Y", "ADMIN" => "N"));
    while($zr = $z->Fetch())
    {
        $APPLICATION->DelGroupRight($mid, array($zr["ID"]));
    }
}

//module option list and default values
$arAllOptions = array(
    array("MODULE_ACTIVE", "Активность", array("checkbox", COption::GetOptionString($mid, "MODULE_ACTIVE"))),
    array("REWARD_SIZE_UR", "% кэшбека юр. лицам", array("text", 5)),
    array("REWARD_SIZE_FZ", "% кэшбека физ. лицам", array("text", 5)),
);



//if request method update
if($_SERVER['REQUEST_METHOD'] == "POST" && CAffettapromo::IsAdmin() && $Update <> '' && check_bitrix_sessid())
{
    foreach($arAllOptions as $ar)
    {
        $name = $ar[0];
        $val = ${$name};
        if($ar[2][0] == "checkbox" && $val != "Y")
        {
            $val = "N";
        }

        COption::SetOptionString($mid, $name, $val);
    }
}

//if request method clear cache
if($_SERVER['REQUEST_METHOD'] == "POST" && CAffettapromo::IsAdmin() && $_POST['clearCache'] == 'Y' && check_bitrix_sessid())
{
    $taggedCache = Application::getInstance()->getTaggedCache(); // Служба пометки кеша тегами
    $taggedCache->clearByTag('affettapromo_module_cache');
}

//tabs list title and name
$aTabs = array(
    array("DIV" => "settings", "TAB" => GetMessage("MAIN_TAB_SET"), "ICON" => "form_settings", "TITLE" => GetMessage("MAIN_TAB_TITLE_SET")),
    array("DIV" => "desc", "TAB" => "Описание", "ICON" => "form_settings", "TITLE" => "Как это работает?"),
    array("DIV" => "rights", "TAB" => "Доступ", "ICON" => "form_settings", "TITLE" => "Уровень доступа к модулю"),
);

include 'includes/tabs.php';
