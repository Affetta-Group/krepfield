<?
/** @global CMain $APPLICATION */
/** @global $DB CDatabase */
/** @global CUserTypeManager $USER_FIELD_MANAGER */
use Bitrix\Main\Loader,
    Bitrix\Affettaredirects\RedirectsTable;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
Loader::includeModule("affettaredirects");
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/affettaredirects/prolog.php");
IncludeModuleLangFile(__FILE__);
$APPLICATION->SetTitle(GetMessage("FORM_PAGE_TITLE"));
require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$claims = RedirectsTable::getList(array('select' => array('*')))->fetchAll();
$head = RedirectsTable::getMap();

require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/affettaredirects/includes/table.php");

require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin_after.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>