<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Title");

use Bitrix\Main\Mail\Event;

        $res = Event::send(array(
            "EVENT_NAME" => "SALE_NEW_ORDER",
            "LID" => "s1",
            "C_FIELDS" => array(
                "ORDER_ID" => 526,
            ),
        ));
        echo "<pre>"; var_dump($res); echo "</pre>";
        echo "<pre>"; var_dump(unserialize('a:12:{s:8:"ORDER_ID";i:525;s:13:"ORDER_REAL_ID";i:525;s:27:"ORDER_ACCOUNT_NUMBER_ENCODE";s:3:"525";s:10:"ORDER_DATE";s:19:"18.06.2024 14:55:42";s:10:"ORDER_USER";s:11:"admin admin";s:5:"PRICE";s:10:"1 029";s:3:"BCC";s:17:"info@krepfield.ru";s:5:"EMAIL";s:16:"admin@affetta.ru";s:10:"ORDER_LIST";}')); echo "</pre>";

        echo "<pre>";
        print_r($_SERVER['DOCUMENT_ROOT']);
        echo "</pre>";

        ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>