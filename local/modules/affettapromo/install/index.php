<?
use Bitrix\Main\Localization\Loc;

use Bitrix\Main\Application;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

if(class_exists("affettapromo")) return;

Class affettapromo extends CModule
{
    var $MODULE_ID = "affettapromo";  // - хранит ID модуля (полный код партнерского модуля);
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

        $this->MODULE_NAME = 'AFFETTA модуль акций';
        $this->MODULE_DESCRIPTION = 'Акция заполни форму получи 300 на счет';
    }


    function InstallDB($install_wizard = true)
    {
        RegisterModule("affettapromo");
        $this->InstallEvents();

//        if(\Bitrix\Main\Loader::includeModule('affettapromo')){
//            if (!Application::getConnection()->isTableExists(Base::getInstance('Bitrix\Affettapromo\ClaimTable')->getDBTableName())) {
//                Base::getInstance('Bitrix\Affettapromo\ClaimTable')->createDBTable();
//            }
//        }

        return true;
    }

    function UnInstallDB($arParams = Array())
    {
//        global $DB;
//
//        $arSql[] = "DROP TABLE affettapromo_claim";
//
//        foreach($arSql as $strSql)
//        {
//            if(!$DB->Query($strSql, true))
//                $arSQLErrors[] = "<hr><pre>Query:\n".$strSql."\n\nError:\n<span style=\"color: red;\">".$DB->db_Error."</span></pre>";
//        }

        $this->UnInstallEvents();
        UnRegisterModule("affettapromo");
        return true;
    }

    function InstallEvents()
    {
        RegisterModuleDependences("sale", "OnSalePayOrder", "affettapromo", "\\Bitrix\\Affettapromo\\Utils", "OnStatusUpdateHandler");
        return true;
    }

    function UnInstallEvents()
    {
        UnRegisterModuleDependences("sale", "OnSalePayOrder", "affettapromo", "\\Bitrix\\Affettapromo\\Utils", "OnStatusUpdateHandler");
        return true;
    }

    function InstallFiles()
    {
        return true;
    }

    function UnInstallFiles()
    {
//        Bitrix\Highloadblock\HighloadBlockTable::delete();
        return true;
    }

    function InstallHL()
    {
        $this->HL_log();
        $this->HL_promocodes();
    }
    public function HL_promocodes() {
        global $APPLICATION;

        Loader::includeModule('highloadblock');

        $hlblock_ID = Bitrix\Highloadblock\HighloadBlockTable::getList(array(
            'select' => array('ID'),
            'filter' => array('=NAME' => 'AffettaPromoCodes'),
            'limit' => 1,
        ))->fetch();

        if(empty($hlblock_ID['ID']))
        {
            $result = Bitrix\Highloadblock\HighloadBlockTable::add(array(
                'NAME' => 'AffettaPromoCodes',
                'TABLE_NAME' => 'affetta_promo_codes',
            ));

            if (!$result->isSuccess())
            {
                $APPLICATION->ThrowException(
                    Loc::getMessage("AFFETTA_SEO_INSTALL_ERROR_ADD")
                );
            }
            else
            {
                $id = $result->getId();
                $this->addUserField($id, 'UF_USER_ID', "ID пользователя", 'N', 'integer');
                $this->addUserField($id, 'UF_CODE', "Код", 'Y');
                $this->addUserField($id, 'UF_CODE_CASH', "Количество бонусов за купон", 'Y', 'double');
                $this->addUserField($id, 'UF_CODE_PRINTED', "Напечатан", 'Y', 'boolean');
                $this->addUserField($id, 'UF_USER_USED_CODE_DATE', "Дата активации", 'N', 'datetime');
            }
            return true;
        }
        else
        {
            $APPLICATION->ThrowException(
                Loc::getMessage("AFFETTA_SEO_INSTALL_ERROR_EXIST")
            );
        }
        return true;
    }
    public function HL_log() {
        global $APPLICATION;

        Loader::includeModule('highloadblock');

        $hlblock_ID = Bitrix\Highloadblock\HighloadBlockTable::getList(array(
            'select' => array('ID'),
            'filter' => array('=NAME' => 'AffettaPromo'),
            'limit' => 1,
        ))->fetch();

        if(empty($hlblock_ID['ID']))
        {
            $result = Bitrix\Highloadblock\HighloadBlockTable::add(array(
                'NAME' => 'AffettaPromo',
                'TABLE_NAME' => 'affetta_promo',
            ));

            if (!$result->isSuccess())
            {
                $APPLICATION->ThrowException(
                    Loc::getMessage("AFFETTA_SEO_INSTALL_ERROR_ADD")
                );
            }
            else
            {
                $id = $result->getId();
                $this->addUserField($id, 'UF_USER_ID', "ID пользователя", 'Y', 'integer');
                $this->addUserField($id, 'UF_OPERATION_TYPE', "Тип операции", 'Y');
                $this->addUserField($id, 'UF_USER_USED_BONUS', "Количество бонусов", 'Y');
                $this->addUserField($id, 'UF_USER_USED_BONUS_DATE', "Дата операции", 'Y', 'datetime');
            }
            return true;
        }
        else
        {
            $APPLICATION->ThrowException(
                Loc::getMessage("AFFETTA_SEO_INSTALL_ERROR_EXIST")
            );
        }
        return true;
    }

    public function addUserField($id, $field_name, $name, $mandatory, $type_id = "string")
    {
        if($type_id == 'boolean'){
            $default_value = false;
        }

        $oUserTypeEntity = new CUserTypeEntity();

        $aUserFields = array(
            'ENTITY_ID'         => 'HLBLOCK_'.$id,
            'FIELD_NAME'        => $field_name,
            'USER_TYPE_ID'      => $type_id,
            'XML_ID'            => '',
            'SORT'              => 100,
            'MULTIPLE'          => 'N',
            'MANDATORY'         => $mandatory,
            'SHOW_FILTER'       => 'S',
            'SHOW_IN_LIST'      => '',
            'EDIT_IN_LIST'      => '',
            'IS_SEARCHABLE'     => 'N',
            'SETTINGS'          => array(
                'DEFAULT_VALUE' => $default_value,
                'SIZE'          => '100',
                'ROWS'          => '1',
                'MIN_LENGTH'    => '0',
                'MAX_LENGTH'    => '0',
                'REGEXP'        => '',
                'PRECISION' => '2'
            ),
            'EDIT_FORM_LABEL'   => array(
                'ru'    => $name,
                'en'    => '',
            ),
            'LIST_COLUMN_LABEL' => array(
                'ru'    => $name,
                'en'    => '',
            ),
            'LIST_FILTER_LABEL' => array(
                'ru'    => $name,
                'en'    => '',
            ),
            'ERROR_MESSAGE' => array(
                'ru'    => '',
                'en'    => '',
            ),
            'HELP_MESSAGE' => array(
                'ru'    => '',
                'en'    => '',
            ),
        );
        $iUserFieldId = $oUserTypeEntity->Add( $aUserFields );
    }

    function DoInstall()
    {
//        $this->InstallFiles();
        $this->InstallDB(false);
        $this->InstallHL();
    }

    function DoUninstall()
    {
//        $this->UnInstallFiles();
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
?>