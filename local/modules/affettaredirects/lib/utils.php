<?php

namespace Bitrix\Affettaredirects;

use COption;
use \Bitrix\Main\Data\Cache;
use \Bitrix\Main\Application;
use \Bitrix\Affettaredirects\RedirectsTable;

class Utils {
    public static function onPageStartHendler()
    {
        global $APPLICATION;

        if (COption::GetOptionString("affettaredirects", "MODULE_ACTIVE") == 'Y') {
            $row = RedirectsTable::getList(array('select' => array('AFTER'), 'filter' => array('BEFORE' => $APPLICATION->GetCurDir(), 'ACTIVE' => 'Y')))->fetch();
            if ($row) {
                LocalRedirect($row['AFTER']);
            }
        }
    }
}