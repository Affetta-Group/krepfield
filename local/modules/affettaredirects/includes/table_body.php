<tbody>
<? foreach($claims as $claim) : ?>
<!--<tr class="adm-list-table-row" oncontextmenu="return [{'DEFAULT':true,'GLOBAL_ICON':'adm-menu-edit','DEFAULT':true,'TEXT':'Изменить','ONCLICK':'BX.adminPanel.Redirect([], \'highloadblock_row_edit.php?ENTITY_ID=7&amp;ID=1&amp;lang=ru\', event);'},-->
<!--{'GLOBAL_ICON':'adm-menu-copy','TEXT':'Копировать','ONCLICK':'BX.adminPanel.Redirect([], \'highloadblock_row_edit.php?ENTITY_ID=7&amp;ID=1&amp;lang=ru&amp;action=copy\', event);'},-->
<!--{'GLOBAL_ICON':'adm-menu-delete','TEXT':'Удалить','ONCLICK':'if(confirm(\'Удалить запись?\')) BX.adminPanel.Redirect([], \'highloadblock_row_edit.php?action=delete&amp;ENTITY_ID=7&amp;ID=1&amp;lang=ru&amp;sessid=4de534e51266b4a3062949705919858e\', event);'}];"-->
<!--    ondblclick="BX.adminPanel.Redirect([], 'highloadblock_row_edit.php?ENTITY_ID=7&amp;ID=1&amp;lang=ru', event);"-->
<!--    title="Двойной щелчок - Изменить">-->
<!--    <td class="adm-list-table-cell adm-list-table-checkbox adm-list-table-checkbox-hover"><input-->
<!--            type="checkbox" class="adm-checkbox adm-designed-checkbox" name="ID[]"-->
<!--            id="tbl_configvars_1_k8DyG" value="1" autocomplete="off" title="Отметить/Снять отметку"><label-->
<!--            class="adm-designed-checkbox-label adm-checkbox" for="tbl_configvars_1_k8DyG"></label>-->
<!--    </td>-->
<!--    <td class="adm-list-table-cell adm-list-table-popup-block"-->
<!--        onclick="BX.adminList.ShowMenu(this.firstChild, this.parentNode.oncontextmenu(), this.parentNode);">-->
<!--        <div class="adm-list-table-popup" title="Действия"></div>-->
<!--    </td>-->

    <? foreach ($claim as $key => $field): ?>

    <td class="adm-list-table-cell">
        <? if ($key == 'ID') : ?>
        <a href="affettaredirects_row_edit.php?ID=<?= $field ?>&amp;lang=ru">Изменить</a>
        <a href="affettaredirects_row_edit.php?MOD=DEL&amp;ID=<?= $field ?>&amp;lang=ru">Удалить</a>
        <? else: ?>
        <?= $field ?>
        <? endif ?>
    </td>

    <? endforeach; ?>

</tr>
<? endforeach; ?>
</tbody>