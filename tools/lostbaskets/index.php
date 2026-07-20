<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Mail\Event;

$sended = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostbaskets/sended.txt");
if ($sended) {
    $sended = explode(",", $sended);
} else {
    $sended = [];
}

$fileWaitToSend = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostbaskets/waitToSend.txt");
if ($fileWaitToSend) $allBasketsUsers = json_decode($fileWaitToSend, true);

$basketIds = [];
foreach ($allBasketsUsers as $basket){
    $basketIds[] = $basket["FUSER_ID"];
}

$date = date('d.m.Y', time() - 86400 * 30);
$dateWait = date('d.m.Y', time() - 60 * 180);
$users = \Bitrix\Sale\Internals\BasketTable::getList([
    "select" => [
        "USER_ID" => "FUSER.USER.ID",
        "USER_EMAIL" => "FUSER.USER.EMAIL",
        "USER_NAME" => "FUSER.USER.NAME",
        "USER_LAST_NAME" => "FUSER.USER.LAST_NAME",
        "USER_SECOND_NAME" => "FUSER.USER.SECOND_NAME",
        "PRICE",
        "FUSER_ID",
        "DATE_INSERT"
    ],
    "filter" => [
        "!USER_ID" => NULL,
        "!FUSER_ID" => array_merge($sended, $basketIds),
        "ORDER_ID" => NULL,
        ">=DATE_INSERT" => $date,
//        "<=DATE_INSERT" => $dateWait
    ],
    "group" => [
        "FUSER.USER.ID",
        "FUSER.USER.EMAIL"
    ]
])->fetchAll();
$waitToSend = [];
foreach ($users as $user) {
    $userId = $user["USER_ID"];
    if (!in_array($user["FUSER_ID"], $sended)) {
        $fullName = $user["USER_NAME"];
        if ($user["USER_SECOND_NAME"]) $fullName .= " " . $user["USER_SECOND_NAME"];
        if ($user["USER_LAST_NAME"]) $fullName .= " " . $user["USER_LAST_NAME"];

        $aOrB = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostbaskets/abTest.txt");
        $waitToSend[$userId]["ID"] = $userId;
        $waitToSend[$userId]["FUSER_ID"] = $user["FUSER_ID"];
        $waitToSend[$userId]["A_OR_B"] = $aOrB;
        $waitToSend[$userId]["TIME_TO_SEND"] = MakeTimeStamp($user["DATE_INSERT"]) + 86400 * ($aOrB == 1 ? 1 : 2); // 24 или 48
        $waitToSend[$userId]["FULL_NAME"] = $fullName; // 24 или 48
        $aOrB == 0 ? $aOrB = 1 : $aOrB = 0;
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostbaskets/abTest.txt", $aOrB);
    }
}


if ($allBasketsUsers) {
    $allBasketsUsers = array_merge($allBasketsUsers, $waitToSend);
} else {
    $allBasketsUsers = $waitToSend;
}

$newWaitToSend = [];
foreach ($allBasketsUsers as $user) {
    $BasketPrice = "";
    $userId = $user["ID"];
    if ((time() > $user["TIME_TO_SEND"]) && $user) {
        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(
            $user["FUSER_ID"],
            \Bitrix\Main\Context::getCurrent()->getSite()
        );
        $BasketPrice = $basket->getPrice();
        $basketList = $basket->getListOfFormatText();
        $ProductsStr = "";
        foreach ($basketList as $product) {
            $ProductsStr .= $product . "<br>";
        }
        $res = Event::send(array(
            "EVENT_NAME" => "LOST_BASKET",
            "LID" => "s1",
            "C_FIELDS" => array(
                "EMAIL" => $user["EMAIL"],
//                "EMAIL" => "v.kurochko@myaffetta.ru",
                "ORDER_USER" => $user["FULL_NAME"],
                "PRICE" => $BasketPrice,
                "ORDER_LIST" => $ProductsStr,
                "SALE_EMAIL" => \Bitrix\Main\Config\Option::get("sale", "order_email", "order@" . $_SERVER["SERVER_NAME"]),
            ),
        ));
        if ($res) {
            $sended[] = $user["FUSER_ID"];
            $logStr = $userId . ";";
            $logStr .= $user["FUSER_ID"] . ";";
            $logStr .= FormatDate("d.m.y", time()) . "\n";
            if ($user["A_OR_B"] == 1) file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostbaskets/sended_A.csv", $logStr, FILE_APPEND);
            else file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostbaskets/sended_B.csv", $logStr, FILE_APPEND);
        }
    } else {
        $add = true;
        foreach ($newWaitToSend as $item) {
            if ($item["ID"] == $user["ID"]) {
                $add = false;
            }
        }
        if ($add) $newWaitToSend[] = $user;
    }
}
file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostbaskets/waitToSend.txt", json_encode($newWaitToSend));
if (is_array($sended)) {
    $strSended = implode(",", $sended);
    file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostbaskets/sended.txt", $strSended);
}