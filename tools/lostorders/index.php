<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Mail\Event;

// Получение всех заказов за последний месяц (если они не были оплачены более суток)
$date = date('d.m.Y', time() - 86400 * 30);
$dateWait = date('d.m.Y', time() - 86400 * 1);


$sended = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostorders/sended.txt");
if ($sended) {
    $sended = explode(",", $sended);
} else {
    $sended = [];
}

$fileWaitToSend = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostorders/waitToSend.txt");
if($fileWaitToSend) $allOrders = json_decode($fileWaitToSend, true);
$orderIds = [];
foreach ($allOrders as $order){
    $orderIds[] = $order["ID"];
}
$dbRes = \Bitrix\Sale\Order::getList([
    'select' => ['ID', "USER_ID", "DATE_INSERT"],
    'filter' => [
//        "USER_ID" => $USER->GetID(),
        "!ID" => array_merge($sended, $orderIds),
        ">=DATE_INSERT" => $date,
//        "<=DATE_INSERT" => $dateWait,
        "PAYED" => "N",
        "CANCELED" => "N",
    ],
    'order' => ['ID' => 'DESC']
]);

$waitToSend = [];
while ($order = $dbRes->fetch()) {
    $oderId = $order["ID"];
    if (!in_array($oderId, $sended)) {
        $aOrB = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostorders/abTest.txt");
        $waitToSend[$oderId]["ID"] = $oderId;
        $waitToSend[$oderId]["USER_ID"] = $order["USER_ID"];
        $waitToSend[$oderId]["A_OR_B"] = $aOrB;
        $waitToSend[$oderId]["TIME_TO_SEND"] = MakeTimeStamp($order["DATE_INSERT"]) + 86400 * ( $aOrB == 1 ? 1 : 2); // 24 или 48
        $aOrB == 0 ? $aOrB = 1 : $aOrB = 0;
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostorders/abTest.txt", $aOrB);
    }
}


// Отправка писем

if ($allOrders) {
    $allOrders = array_merge($allOrders, $waitToSend);
} else {
    $allOrders = $waitToSend;
}



$newWaitToSend = [];
foreach ($allOrders as $order) {
    $oderId = $order["ID"];
    if (in_array($oderId, $sended)) continue;
    $userId = $order["USER_ID"];
    $user = CUser::GetByID($userId)->Fetch();
    $urlToOrder = "";
    if ($oderId) $urlToOrder = "https://" . $_SERVER["SERVER_NAME"] . "/personal/orders/" . $oderId . "/";

    $fullName = $user["NAME"];
    if ($user["SECOND_NAME"]) $fullName .= " " . $user["SECOND_NAME"];
    if ($user["LAST_NAME"]) $fullName .= " " . $user["LAST_NAME"];

    $basket = \Bitrix\Sale\Order::load($oderId)->getBasket();
    $BasketPrice = $basket->getPrice();
    $basketList = $basket->getListOfFormatText();
    $ProductsStr = "";
    foreach ($basketList as $product) {
        $ProductsStr .= $product . "<br>";
    }
    if (time()> ($order["TIME_TO_SEND"])) {
        $res = Event::send(array(
            "EVENT_NAME" => "LOST_ORDER",
            "LID" => "s1",
            "C_FIELDS" => array(
                "EMAIL" => $user["EMAIL"],
//                "EMAIL" => "v.kurochko@myaffetta.ru",
                "PRICE" => $BasketPrice,
                "ORDER_LIST" => $ProductsStr,
                "ORDER_USER" => $fullName,
                "SALE_EMAIL" => \Bitrix\Main\Config\Option::get("sale", "order_email", "order@" . $_SERVER["SERVER_NAME"]),
                "ORDER_URL" => $urlToOrder,
            ),
        ));
        if($res) {
            $sended[] = $oderId;
            $logStr = $order["USER_ID"] . ";";
            $logStr .= $order["ID"] . ";";
            $logStr .= FormatDate("d.m.y", time()) . "\n";

            if ($order["A_OR_B"] == 1) file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostorders/sended_A.csv", $logStr, FILE_APPEND);
            else file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostorders/sended_B.csv", $logStr, FILE_APPEND);
        }
    }else{
        $add = true;
        foreach ($newWaitToSend as $item){
            if($item["ID"] == $order["ID"]){
                $add = false;
            }
        }
        if($add) $newWaitToSend[] = $order;
    }
}



if($newWaitToSend) file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostorders/waitToSend.txt", json_encode($newWaitToSend));
if (is_array($sended)) {
    $strSended = implode(",", $sended);
    file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/lostorders/sended.txt", $strSended);
}