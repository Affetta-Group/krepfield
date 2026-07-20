<?
class CAffettaredirects
{
    public static function IsAdmin()
    {
        global $USER, $APPLICATION;
        if (!is_object($USER)) $USER = new CUser;
        if ($USER->IsAdmin()) return true;
        $FORM_RIGHT = $APPLICATION->GetGroupRight("affettaredirects");
        if ($FORM_RIGHT>="W") return true;
    }
}