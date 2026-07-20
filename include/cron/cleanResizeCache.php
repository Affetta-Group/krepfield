<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');


$keypass = 'xdrhgdHRThhfj36fgjfxHSJTEDHf553hfffhhtjdDHthkr';

if (!empty($_GET['keypass']) && $_GET['keypass'] == $keypass) {
    global $USER;

    $path = $_SERVER["DOCUMENT_ROOT"] . "/upload/resize_cache/";

    function rmRec($path)
    {
        if (is_file($path)) return unlink($path);
        if (is_dir($path)) {
            foreach (scandir($path) as $p) if (($p != '.') && ($p != '..'))
                rmRec($path . DIRECTORY_SEPARATOR . $p);
            return rmdir($path);
        }
        return false;
    }

    rmRec($path);
}