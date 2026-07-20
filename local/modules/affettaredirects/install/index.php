<?
use Bitrix\Main\Localization\Loc;

use Bitrix\Main\Application;
use Bitrix\Main\Entity\Base;

Loc::loadMessages(__FILE__);

if(class_exists("affettaredirects")) return;

Class affettaredirects extends CModule
{
    var $MODULE_ID = "affettaredirects";  // - хранит ID модуля (полный код партнерского модуля);
    var $MODULE_VERSION;            //- текущая версия модуля в формате XX.XX.XX;
    var $MODULE_VERSION_DATE;       //- строка содержащая дату версии модуля; дата должна быть задана в формате YYYY-MM-DD HH:MI:SS;
    var $MODULE_NAME;               // - имя модуля;
    var $MODULE_DESCRIPTION;        //- описание модуля;
    var $MODULE_CSS;                //
    var $MODULE_GROUP_RIGHTS = "Y"; //- если задан метод GetModuleRightList, то данное свойство должно содержать Y

    public function __construct()
    {
        $arModuleVersion = array();

        $path = str_replace("\\","/",__FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include(__DIR__.'/version.php');

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

        $this->MODULE_NAME = 'AFFETTA редиректы';
        $this->MODULE_DESCRIPTION = 'Редиректы';
    }


    function InstallDB($install_wizard = true)
    {
        RegisterModule("affettaredirects");

        if(\Bitrix\Main\Loader::includeModule('affettaredirects')){
            if (!Application::getConnection()->isTableExists(Base::getInstance('Bitrix\Affettaredirects\RedirectsTable')->getDBTableName())) {
                Base::getInstance('Bitrix\Affettaredirects\RedirectsTable')->createDBTable();
            }
        }

        RegisterModuleDependences("main", "OnPageStart", "affettaredirects", "\\Bitrix\\Affettaredirects\\Utils", "onPageStartHendler");

        return true;
    }

    function UnInstallDB($arParams = Array())
    {
        UnRegisterModuleDependences("main", "OnPageStart", "affettaredirects", "\\Bitrix\\Affettaredirects\\Utils", "onPageStartHendler");

        global $DB;

        $arSql[] = "DROP TABLE affetta_redirects";

        foreach($arSql as $strSql)
        {
            if(!$DB->Query($strSql, true))
                $arSQLErrors[] = "<hr><pre>Query:\n".$strSql."\n\nError:\n<span style=\"color: red;\">".$DB->db_Error."</span></pre>";
        }

        UnRegisterModule("affettaredirects");
        return true;
    }

    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function InstallFiles()
    {
        if($_ENV["COMPUTERNAME"]!='BX')
        {
            CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/affettaredirects/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true);
        }
        return true;
    }

    function UnInstallFiles()
    {
        DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/affettaredirects/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
        return true;
    }

    function DoInstall()
    {
        $this->InstallFiles();
        $this->InstallDB(false);
    }

    function DoUninstall()
    {
        $this->UnInstallFiles();
        $this->UnInstallDB(false);
    }

    function GetModuleRightList()
    {
        global $MESS;
        $arr = array(
            "reference_id" => array("D","R","W"),
            "reference" => array(
                "[D] ".GetMessage("FORM_DENIED"),
                "[R] ".GetMessage("FORM_OPENED"),
                "[W] ".GetMessage("FORM_FULL"))
        );
        return $arr;
    }
}