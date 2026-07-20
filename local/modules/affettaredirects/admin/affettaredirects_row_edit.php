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

$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
if ($request->isPost()) {
    $rows = RedirectsTable::getMap();
    foreach ($rows as $row) {
        if ($row->getDataType() == 'boolean') {
            $arParams[$row->getName()] = (!empty($request->get($row->getName())) ? $request->get($row->getName()) : 'N');
        } else {
            $arParams[$row->getName()] = $request->get($row->getName());
        }
    }
    if (isset($_REQUEST['ID'])) {
        RedirectsTable::update($_REQUEST['ID'], $arParams);
        LocalRedirect("/bitrix/admin/affettaredirects_info.php?lang=ru");
    } else {
        $result = RedirectsTable::add($arParams);
        LocalRedirect("/bitrix/admin/affettaredirects_info.php?lang=ru");
    }
}

if ($_REQUEST['MOD'] == 'DEL' && isset($_REQUEST['ID'])){
    $result = RedirectsTable::delete($_REQUEST['ID']);
    LocalRedirect("/bitrix/admin/affettaredirects_info.php?lang=ru");
}

?>
<div style="border: red 1px solid; padding: 5px 10px; margin-bottom:10px;">
    <p>Можно копировать вместе с доменом - он потом обрежется</p>
    <p>Если не добавляется - значит срабатывает проверка на уникальность урла до</p>
</div>
<?php

if (isset($_REQUEST['ID'])){
?>
Редактировать <?= $_REQUEST['ID'] ?>
<form method="POST">
    <?php
    $rows = RedirectsTable::getMap();
    $claim = RedirectsTable::getByPrimary($_REQUEST['ID'])->fetch();
    foreach ($rows as $row) {
        if($row->getName() == 'ID') continue;
        if ($row->getDataType() == 'boolean') {
            ?>
            <div>
                <div>
                    <?=$row->getName()?>
                </div>
                <div>
                    <input type="checkbox" value="Y" name="<?=$row->getName()?>" <?= ($claim[$row->getName()] == 'Y' ? 'checked' : '') ?>>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div>
                <div>
                    <?=$row->getName()?>
                </div>
                <div>
                    <input size="100" type="text" value="<?= $claim[$row->getName()] ?>" name="<?=$row->getName()?>">
                </div>
            </div>
            <?php
        }
    } ?>
    <input type="hidden" name="ID" value="<?= $_REQUEST['ID'] ?>">
    <input type="submit">
</form>
<?php
} else {
?>
Добавить
<form method="POST">
<?php
    $rows = RedirectsTable::getMap();
    foreach ($rows as $row) {
        if($row->getName() == 'ID') continue;
        if ($row->getDataType() == 'boolean') {
            ?>
            <div>
                <div>
                    <?=$row->getName()?>
                </div>
                <div>
                    <input type="checkbox" value="Y" name="<?=$row->getName()?>" checked>
                </div>
            </div>
            <?php
        } else {
        ?>
        <div>
            <div>
                <?=$row->getName()?>
            </div>
            <div>
                <input size="100" type="text" value="" name="<?=$row->getName()?>">
            </div>
        </div>
    <?php
        }
    } ?>
    <input type="submit">
</form>
<?php } ?>

<?php

require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin_after.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>