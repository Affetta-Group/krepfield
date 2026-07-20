<?php

//tabs init
$tabControl = new CAdminTabControl("tabControl", $aTabs);
$tabControl->Begin();

//form init
?><form method="POST" id="affettaredirects_form_settings" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&lang=<?=LANGUAGE_ID?>"><?=bitrix_sessid_post()?>
    <?
    //first tab
    $tabControl->BeginNextTab();?>
    <?php
    if(COption::GetOptionString($mid, "MODULE_ACTIVE") == 'Y')
        echo "Модуль активирован";
    else
        echo "Модуль деактивирован";

    //arr options
    if (is_array($arAllOptions)):
        foreach($arAllOptions as $Option):
            $val = COption::GetOptionString($mid, $Option[0]);
            $type = $Option[2];
            ?>
            <tr>
                <td valign="top" width="50%"><?	if($type[0]=="checkbox")
                        echo "<label for=\"".htmlspecialcharsbx($Option[0])."\">".$Option[1]."</label>";
                    else
                        echo $Option[1];?>
                </td>
                <td valign="top" nowrap width="50%"><?
                    if($type[0]=="checkbox"):
                        ?><input type="checkbox" name="<?echo htmlspecialcharsbx($Option[0])?>" id="<?echo htmlspecialcharsbx($Option[0])?>" value="Y"<?if($val=="Y")echo" checked";?>><?
                    elseif($type[0]=="text"):
                        ?><input type="text" size="<?echo $type[1]?>" maxlength="255" value="<?echo htmlspecialcharsbx($val)?>" name="<?echo htmlspecialcharsbx($Option[0])?>"><?
                    elseif($type[0]=="textarea"):
                        ?><textarea rows="<?echo $type[1]?>" cols="<?echo $type[2]?>" name="<?echo htmlspecialcharsbx($Option[0])?>"><?echo htmlspecialcharsbx($val)?></textarea><?
                    endif;
                    ?></td>
            </tr>
        <?
        endforeach;
    endif;

    //third tab
    $tabControl->BeginNextTab();?>
    <div class="adm-info-message" style="width: 60%">
        Настройки модуля находятся в меню Сервисы - AFFETTA - AFFETTA редиректы...<br>
        Разработал Артемий Маратович
    </div>
    <?
    //forth tab
    $tabControl->BeginNextTab();?>
    <?
    echo "Ваши права: ".$FORM_RIGHT;
    $module_id = "affettaredirects"; //need for rights
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");?>

    <? //buttons
    $tabControl->Buttons();?>
    <input <?if ($FORM_RIGHT<"W") echo "disabled" ?> type="submit" name="Update" value="<?echo GetMessage("FORM_SAVE_CUSTOM")?>">
    <script type="text/javascript">
        function RestoreDefaults()
        {
            if(confirm('<?echo AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>'))
                window.location = "<?echo $APPLICATION->GetCurPage()?>?RestoreDefaults=Y&lang=<?=LANGUAGE_ID?>&mid=<?echo urlencode($mid)?>&<?=bitrix_sessid_get()?>";
        }
    </script>
    <input <?if ($FORM_RIGHT<"W") echo "disabled" ?> type="button" title="<?echo GetMessage("MAIN_HINT_RESTORE_DEFAULTS")?>" OnClick="RestoreDefaults();" value="<?echo GetMessage("MAIN_RESTORE_DEFAULTS")?>">
    <input type="reset" name="reset" value="<?=GetMessage("FORM_RESET")?>">
    <?$tabControl->End();?>

</form>