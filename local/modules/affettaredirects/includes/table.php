<div id="tbl_configvars_result_div" class="adm-list-table-layout">
    <div class="adm-list-table-wrap">
        <div class="adm-list-table-top">
            <a href="/bitrix/admin/affettaredirects_row_edit.php?&amp;lang=ru"
               class="adm-btn adm-btn-save adm-btn-add" title="Добавить запись" id="btn_new">Добавить запись</a>

            <script type="text/javascript"> if (window.BXHotKeys !== undefined) {
                    BXHotKeys.Add("", "var d=BX (\'btn_new\'); if (d) location.href = d.href;", 5, 'Кнопка добавить', 0);
                } </script>
            <div class="adm-small-button adm-table-setting" title="Настроить внешний вид списка" onclick="this.blur();BX.adminList.ShowMenu(this, [{'GLOBAL_ICON':'adm-menu-setting','TEXT':'Настроить','TITLE':'Настроить внешний вид списка','ONCLICK':'tbl_configvars.ShowSettings(\'/bitrix/admin/highloadblock_rows_list.php?mode=settings&amp;ENTITY_ID=7&amp;lang=ru\')'},
{'GLOBAL_ICON':'adm-menu-excel','TEXT':'Excel','TITLE':'Выгрузить данные из списка в Excel','ONCLICK':'location.href=\'/bitrix/admin/highloadblock_rows_list.php?mode=excel&amp;ENTITY_ID=7&amp;lang=ru\''}]); return false;"></div>
        </div>
        <form method="POST" onsubmit="return BX.ajax.submitComponentForm(this, 'tbl_configvars_result_div', true);"
              id="form_tbl_configvars" name="form_tbl_configvars"
              action="/bitrix/admin/highloadblock_rows_list.php?mode=frame&amp;ENTITY_ID=7&amp;lang=ru"><input
                    type="hidden" name="sessid" id="sessid" value="4de534e51266b4a3062949705919858e">
            <table class="adm-list-table" id="tbl_configvars">
                <?
                require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/affettaredirects/includes/table_head.php");
                require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/affettaredirects/includes/table_body.php");
                ?>
            </table>
            <div class="adm-list-table-footer" id="tbl_configvars_footer">
                <input type="hidden" name="action_button" id="tbl_configvars_action_button" value="">
                <span class="adm-selectall-wrap"><input type="checkbox" class="adm-checkbox adm-designed-checkbox"
                                                        name="action_target" value="selected" id="action_target"
                                                        onclick="if(this.checked &amp;&amp; !confirm('Вы уверены, что хотите применить действие для ВСЕХ записей в списке, в том числе на других страницах списка, а не только для отмеченных флажками?')) {this.checked=false;} tbl_configvars.EnableActions();"
                                                        title="Применить действие для всех записей в списке"><label
                            for="action_target" class="adm-checkbox adm-designed-checkbox-label"></label><label
                            title="Применить действие для всех записей в списке" for="action_target"
                            class="adm-checkbox-label">Для всех</label></span>

                <span class="adm-table-item-edit-wrap">
<a href="javascript:void(0)" class="adm-table-btn-edit adm-edit-disable" hidefocus="true"
   onclick="this.blur();if(tbl_configvars.IsActionEnabled('edit')){document.forms['form_tbl_configvars'].elements['action_button'].value='edit'; ; BX.submit(document.forms.form_tbl_configvars, 'action_button', 'edit');}"
   title="Редактировать отмеченные записи" id="action_edit_button"></a><a href="javascript:void(0);"
                                                                          class="adm-table-btn-delete adm-edit-disable"
                                                                          hidefocus="true"
                                                                          onclick="this.blur();if(tbl_configvars.IsActionEnabled() &amp;&amp; confirm((document.getElementById('action_target') &amp;&amp; document.getElementById('action_target').checked? 'Вы уверены, что хотите удалить ВСЕ записи из списка?':'Вы уверены, что хотите удалить отмеченные записи?'))) {document.forms['form_tbl_configvars'].elements['action_button'].value='delete'; ; BX.submit(document.forms.form_tbl_configvars, 'action_button', 'delete');}"
                                                                          title="Удалить записи"
                                                                          id="action_delete_button"></a>
	</span>
                <span class="adm-table-counter" id="tbl_configvars_selected_count">Выбрано: <span>0</span></span>
            </div>

        </form>
    </div>
    <div class="adm-navigation">
        <div class="adm-nav-pages-block">
            <span class="adm-nav-page adm-nav-page-prev"></span>
            <span class="adm-nav-page-active adm-nav-page">1</span>
            <span class="adm-nav-page adm-nav-page-next"></span>
        </div>
        <div class="adm-nav-pages-total-block"> 1 – 3 из 3</div>
        <div class="adm-nav-pages-number-block"><span class="adm-nav-pages-number">
		<span class="adm-nav-pages-number-text">На странице:</span><span class="adm-select-wrap"><select name=""
                                                                                                         class="adm-select"
                                                                                                         onchange="if(this[selectedIndex].value=='0'){tbl_configvars.GetAdminList('/bitrix/admin/highloadblock_rows_list.php?PAGEN_1=1&amp;SHOWALL_1=1&amp;ENTITY_ID=7&amp;lang=ru');}else{tbl_configvars.GetAdminList('/bitrix/admin/highloadblock_rows_list.php?PAGEN_1=1&amp;SHOWALL_1=0&amp;SIZEN_1='+this[selectedIndex].value+'&amp;ENTITY_ID=7&amp;lang=ru');}">
		<option value="10">10</option>
		<option value="20" selected="selected">20</option>
		<option value="50">50</option>
		<option value="100">100</option>
		<option value="200">200</option>
		<option value="500">500</option>
			<option value="0">все</option>
	</select></span></span></div>
    </div>
    <script type="text/javascript">
        var topWindow = (window.BX || window.parent.BX).PageObject.getRootWindow();
        var parentWindow = (window.BX || window.parent.BX).PageObject.getParentWindowOfCurrentHost(window);
        topWindow.BX.adminHistory.put('/bitrix/admin/highloadblock_rows_list.php?PAGEN_1=1&amp;SIZEN_1=20&amp;ENTITY_ID=7&amp;lang=ru', topWindow.BX.proxy((topWindow.tbl_configvars) ? parentWindow.tbl_configvars.GetAdminList : tbl_configvars.GetAdminList, window.tbl_configvars), ['mode', 'table_id']);</script>
</div>