<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Mail\Event;

$date = date('d.m.Y', time() - 86400 * 30);
$dateWait = date('d.m.Y', time() - 86400 * 2);


$dbRes = \Bitrix\Sale\Order::getList([
//    'select' => ['ID'],
    'filter' => [
        "USER_ID" => $USER->GetID(),
        ">=DATE_INSERT" => $date,
        "<=DATE_INSERT" => $dateWait,
        "PAYED" => "N",
        "CANCELED" => "N",
    ],
    'order' => ['ID' => 'DESC']
]);


$sended = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/givediscount/sended.txt");
if ($sended) {
    $sended = explode(",", $sended);
} else {
    $sended = [];
}


while ($order = $dbRes->fetch()) {
    $oderId = $order["ID"];

    if (!in_array($oderId, $sended)) {
        $sended[] = $oderId;
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

        echo "<pre>"; var_dump(); echo "</pre>";


//        $res = Event::send(array(
//            "EVENT_NAME" => "LOST_ORDER",
//            "LID" => "s1",
//            "C_FIELDS" => array(
////                "EMAIL" => $user["USER_EMAIL"],
//                "EMAIL" => "v.kurochko@myaffetta.ru",
//                "PRICE" => $BasketPrice,
//                "ORDER_LIST" => $ProductsStr,
//                "ORDER_USER" => $fullName,
//                "SALE_EMAIL" => \Bitrix\Main\Config\Option::get("sale", "order_email", "order@" . $_SERVER["SERVER_NAME"]),
//                "ORDER_URL" => $urlToOrder,
//            ),
//        ));
        break; // test
    }
}


if (is_array($sended)) {
    $strSended = implode(",", $sended);
    file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/tools/givediscount/sended.txt", $strSended);
}