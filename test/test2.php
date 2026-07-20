<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


use Bitrix\Sale;


//$orderId = 512;
//$coupon = "SL-RLART-SQO032L";
//$order = Sale\Order::load($orderId);
//Sale\DiscountCouponsManager::init(
//    Sale\DiscountCouponsManager::MODE_ORDER, [
//        "userId" => $order->getUserId(),
//        "orderId" => $order->getId()
//    ]
//);
//Sale\DiscountCouponsManager::add($coupon);
//$discounts->calculate();
//$order->save();

//$orderId = 512;
//$coupon = "SL-RLART-SQO032L";
//$order = Sale\Order::load($orderId);
//$discounts = $order->getDiscount();
//$discounts->setApplyResult(array('COUPON_LIST' => array($coupon => 'N')));
//$discountsCalculateResult = $discounts->calculate();
//$result = $discountsCalculateResult->getData();
//$order->applyDiscount($result);
//$order->save();
$materials = "MS Polyamide А2 А4";
if(count(explode(" ", $materials)) > 0){
    $materialsArr = explode(" ", $materials);
    usort($materialsArr, function ($a, $b) {
        return strcmp($a, $b);
    });
    usort($materialsArr, function ($a, $b) {
        return strcmp($a, $b);
    });
    $materials = implode(" ", $materialsArr);
    $fileRes = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/test.txt");
    file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/test.txt", $fileRes . $materials . "\n");
}

$materials = "Ms Polyamide А2 А4";
$materials = str_replace("А", "A", $materials);




$arr = explode(" ", $materials);
$res2 = $arr[3];
foreach ($arr as $key => $item) {
    $arr[$key] = trim(strval($item));
}
usort($arr, function ($a, $b) {
    return strcmp($a, $b);
});
echo "<pre>"; var_dump($arr); echo "</pre>";

//$res1 = iconv('UTF-8', 'ASCII//TRANSLIT', trim($res1));
//$res2 = iconv('UTF-8', 'ASCII//TRANSLIT', trim($res2));
//
//echo "<pre>"; var_dump($res1); echo "</pre>";
//echo "<pre>"; var_dump($res2); echo "</pre>";
//echo "<pre>"; var_dump(strcmp($res1, $res2)); echo "</pre>";
