<thead>
<tr class="adm-list-table-header">
<!--    <td class="adm-list-table-cell adm-list-table-checkbox"-->
<!--        onclick="this.firstChild.firstChild.click(); return BX.PreventDefault(event);">-->
<!--        <div class="adm-list-table-cell-inner"><input class="adm-checkbox adm-designed-checkbox"-->
<!--                                                      type="checkbox" id="tbl_configvars_check_all"-->
<!--                                                      onclick="tbl_configvars.SelectAllRows(this); return BX.eventCancelBubble(event);"-->
<!--                                                      title="Отметить все/Снять отметку у всех"><label-->
<!--                for="tbl_configvars_check_all" class="adm-designed-checkbox-label"></label></div>-->
<!--    </td>-->
<!--    <td class="adm-list-table-cell adm-list-table-popup-block" title="Колонка действий">-->
<!--        <div class="adm-list-table-cell-inner"></div>-->
<!--    </td>-->

    <? foreach ($head as $item) : ?>
    <td class="adm-list-table-cell adm-list-table-cell-sort-up"
        onclick="tbl_configvars.Sort('/bitrix/admin/highloadblock_rows_list.php?ENTITY_ID=7&amp;lang=ru&amp;by=ID&amp;order=desc', false, arguments);"
        title="Сортировка: ID  (упорядочено по возрастанию)">
        <div class="adm-list-table-cell-inner"><?= $item->getName() ?></div>
    </td>
    <? endforeach; ?>
</tr>
</thead>