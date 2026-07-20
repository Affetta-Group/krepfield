<?

use Dompdf\Dompdf,
    Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem;
if (($arResult["ORDER"]["USER_ID"] == $USER->GetID()  && $isBill) || $USER->IsAdmin()):
//            create bill
    require_once 'dompdf/autoload.inc.php';

    //            get order
    $order = Bitrix\Sale\Order::load($arResult["ORDER_ID"]);
    $shipmentCollection = $order->getShipmentCollection();
    $shipment = $shipmentCollection->createItem();
    $service = Bitrix\Sale\Delivery\Services\Manager::getById($arResult["ORDER"]["DELIVERY_ID"]);


    $res = CSaleBasket::GetList(array(), array("ORDER_ID" => $arResult["ORDER_ID"])); // ID заказа
    while ($arItem = $res->GetNext()) {
        $arResult["PRODUCTS"][$arItem["PRODUCT_ID"]] = $arItem;
        $ids[] = $arItem["PRODUCT_ID"];
    }
    $arResult["PRODUCTS"]["DELIVERY"]["PRICE"] = $arResult["ORDER"]["PRICE_DELIVERY"];
    $arResult["PRODUCTS"]["DELIVERY"]["QUANTITY"] = 1;
    $arResult["PRODUCTS"]["DELIVERY"]["NAME"] = $service["NAME"];


    $arSelect = ["PROPERTY_KF_DLYA_SAYTA_VES_KG", "ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM"];
    $arFilter = ["ID" => $ids];
    $res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
    while ($ob = $res->GetNext()) {
        $arResult["PRODUCTS"][$ob["ID"]]["WEIGHT"] = $ob["PROPERTY_KF_DLYA_SAYTA_VES_KG_VALUE"];
    }
    $props = $order->getPropertyCollection()->getArray();
    $props["STRING"] = "";
    foreach ($props["properties"] as $prop) {
        $string = "";
        if ($prop["NAME"] == "ИНН" && $prop["VALUE"][0]) $string = $prop["NAME"] . ":" . $prop["VALUE"][0] . ", ";
        if ($prop["NAME"] == "КПП" && $prop["VALUE"][0]) $string = $prop["NAME"] . ":" . $prop["VALUE"][0] . ", ";
        if ($prop["NAME"] == "Название компании" && $prop["VALUE"][0]) $string = $prop["VALUE"][0] . ", ";
        if ($prop["NAME"] == "Юр адрес" && $prop["VALUE"][0]) $string = $prop["VALUE"][0] . ", ";
        if ($prop["NAME"] == "Телефон" && $prop["VALUE"][0]) $string = $prop["VALUE"][0] . ", ";

        $string ? $props["STRING"] .= $string : "";
    }
    $dompdf = new Dompdf();
    $dompdf->set_option("enable_remote", true);

    $date = FormatDate('<\s\p\a\n>j F Y г.', date('Y-m-d H:i:s'));
    $date2=date('d m Y')." г.";
    $products = '';
    $endPrice = 0;
    //(float)$arResult["WEIGHT"] = 0;
    $c = 1;
    foreach ($arResult["PRODUCTS"] as $key => $prod) {
        $arResult["WEIGHT"][$c] += floatval(str_replace(",", ".", $prod["WEIGHT"]));
        $arResult["WEIGHT"][$c] *= $prod["QUANTITY"];
        $endPrice += $prod["PRICE"] * $prod["QUANTITY"];
        $products .= '<tr style=" border-bottom: 1px solid #000; font-size: 10px; line-height: 10px">
            <td style="width: 10%; border-right: 1px solid #000">' . $c . '</td>
            <td style="width: 60%; border-right: 1px solid #000">' . $prod["NAME"] . '</td>
            <td style="width: 52px; border-right: 1px solid #000; table-layout: fixed;">' . $prod["QUANTITY"] . '</td>
            <td style="width: 55px; flex-shrink: 0; border-right: 1px solid #000">шт</td>
            <td style="width: 48px; flex-shrink: 0; border-right: 1px solid #000">' . round($prod["PRICE"], 2) . '</td>
            <td style="width: 59px; flex-shrink: 0">' . round($prod["PRICE"], 2) * $prod["QUANTITY"] . '</td>
        </tr>';
        $c++;
    }
    $nds = ($endPrice * 22) / 122;
    $arResult["WEIGHT"] = array_sum($arResult["WEIGHT"]);


    //if ((int)$arResult["ORDER_ID"] < 1000) (string)$oderId = "0" . (string)$arResult["ORDER_ID"];
    $dompdf->loadHtml('<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>' . date("ymd") . $arResult["ORDER_ID"] . '</title>
    <style>
        body {
            font-family: "DejaVu Sans";
            font-size: 12px;
        }

        td, tr, table {
            padding: 0;
            margin: 0;
            border-spacing: 0px;
            border-collapse: collapse;
            vertical-align: center;
        }
        table {
            width: 100%;
        }
        h1, h2{
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="bill-top" style="display: flex; margin-bottom: 50px">
        <table style="width: 100%">
            <tr style="border: 1px solid #000; width: 100%">
                <td style="width: 20%; border-right: 1px solid #000">
                    <div class="bill-logo">
                        <img height="95" width="192" src="https://'.$_SERVER['HTTP_HOST']. SITE_TEMPLATE_PATH.'/assets/images/bill-logo.png"
                             alt="logo" style="margin-top: px">
                    </div>
                </td>
                <td style="width: 80%">
                    <div class="bill-text" style="text-align: left; font-size: 6px; padding-left: 10px">
                        1. Оплата данного счета означает полное согласие покупателя с номенклатурой и условиями отгрузки товара. Уведомление об оплате обязательно, в противном случае не гарантируется наличие товара на складе. <br>
2. Резервирование товара на количество и цены, указанные в счете, действительны в течение 3-ти рабочих дней.<br>
3. Самовывозом товар отгружается со склада Поставщика только при наличии корректно оформленной Доверенности (форма № М2/М2а Госкомстат РФ №71а от 30.10.1997г). <br>
После получения товара со склада Поставщика претензии по комплектации, качеству и упаковке груза не принимаются.<br>
4. При отправке груза через транспортную компанию претензии по комплектации, качеству и упаковке груза принимаются в течение 3-х рабочих дней после даты получения товара в транспортной компании.<br>
5. Мерный товар надлежащего качества, отгруженный со склада Поставщика в пользу Покупателя, в том числе тросы и цепи, возврату и обмену не подлежит.
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <table>
        <tr>
            <td style="width: 100%;">
                <table style="border: 1px solid #000">
                    <tr>
                        <td style="width: 50%">
                            <table>
                                <tr style="width: 100%; border-right: 1px solid #000; border-bottom: 1px solid #000">
                                    <td style="width: 100%;">ФИЛИАЛ "ЦЕНТРАЛЬНЫЙ" БАНКА ВТБ (ПАО) г. Москва</td>
                                </tr>
                                <tr style="width: 100%;  border-right: 1px solid #000; border-bottom: 1px solid #000">
                                    <td>Банк получателя</td>
                                </tr>
                            </table>
                            <table>
                                <tr style="width: 100%;">
                                    <td style="width: 50%;  border-right: 1px solid #000; border-bottom: 1px solid #000">ИНН 7751178449</td>
                                    <td style="width: 50%;  border-right: 1px solid #000; border-bottom: 1px solid #000">КПП 775101001</td>
                                </tr>
                            </table>
                            <table>
                                <tr style="width: 100%; border-right: 1px solid #000; border-bottom: 1px solid #000; font-weight: 700">
                                    <td>
                                        ООО "КРЕПФИЛД"
                                    </td>
                                </tr>
                                <tr style="width: 100%; border-right: 1px solid #000">
                                    <td>
                                        Получатель
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 50%">
                            <table>
                                <tr>
                                    <td style="width: 25%; border-right: 1px solid #000; border-bottom: 1px solid #000">
                                        БИК
                                    </td>
                                    <td style="width: 75%;  border-bottom: 1px solid #000">
                                        044525411
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 25%; border-right: 1px solid #000; border-bottom: 1px solid #000">
                                        Сч. №
                                    </td>
                                    <td style="width: 75%;  border-bottom: 1px solid #000">
                                        30101810145250000411
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #000">
                                    <td style="width: 25%">
                                     
                                    </td>
                                    <td style="width: 75%">
                                     
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td style="width: 25%; border-right: 1px solid #000; border-bottom: 1px solid #000">
                                        Сч. №
                                    </td>
                                    <td style="width: 75%; border-bottom: 1px solid #000">
                                        40702810207250000400
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
    </table>
   
    <h1 style="border-bottom: 2px solid #000; text-align: center">Счет на оплату № ' . $arResult["ORDER_ID"] . ' от ' . $date2. '</h1>
    <table>
        <tr>
            <td style="width: 10%;">Поставщик:</td>
            <td> ООО "Крепфилд" - 108809, г.Москва, вн.тер.г. Муниципальный округ Внуково, кв-л 63, д. 1Б, стр. 4
            </td>
        </tr>
        <tr><td> </td></tr>
        <tr>
            <td style="width: 15%">Покупатель:</td>
            <td>' . $props["STRING"] . '</td>
        </tr>
         <tr><td> </td></tr>
    </table>
    <table style="text-align: center; border: 1px solid #000">
        <tr style="font-weight: bold; border-bottom: px solid #000">
            <td style="width: 10%; border-right: 1px solid #000">№</td>
            <td style="width: 60%; border-right: 1px solid #000">Товары (работы, услуги)</td>
            <td style="width: 10%">Количество</td>
            <td style="width: 10%; border-right: 1px solid #000"></td>
            <td style="width: 10%; border-right: 1px solid #000">Цена</td>
            <td style="width: 10%">Сумма</td>
        </tr>
       ' . $products . '
       
    </table>
   <table>
   <tr>
            <td style="width: 10%"></td>
            <td style="width: 60%"></td>
            <td style="width: 0%"></td>
            <td style="width: 0%"></td>
            <td style="width: 10%; font-weight: bold;">Итого:</td>
            <td style="width: 20%; text-align: center; font-weight: bold">' . round($endPrice, 2) . ' руб.</td>
        </tr>
         <tr>
            <td style="width: 10%"></td>
            <td style="width: 60%"></td>
            <td style="width: 0%"></td>
            <td style="width: 0%"></td>
            <td style="width: 30%; font-weight: bold;">В том числе НДС (22%):</td>
            <td style="width: 20%; text-align: center; font-weight: bold">' . round($nds, 2) . ' руб.</td>
        </tr>
         <tr>
            <td style="width: 10%"></td>
            <td style="width: 60%"></td>
            <td style="width: 0%"></td>
            <td style="width: 0%"></td>
            <td style="width: 10%; font-weight: bold;">Итого вес (Нетто):</td>
            <td style="width: 20%; text-align: center; font-weight: bold">' . $arResult["WEIGHT"] . ' кг</td>
        </tr>
</table>
</div>
<br>
<table style="border: 0">
    <tr style="border: 0">
        <td style="width: 30%; border: 0; text-align: left; font-weight: bold">Генеральный директор</td>
        <td style="width: 25%; border: 0; border-bottom: 1px solid #000; text-align: center"><img height="60px" src="https://'.$_SERVER['HTTP_HOST'] . SITE_TEMPLATE_PATH.'/assets/images/labz.png" alt=""></td>
        <td style="width: 5%; border: 0"></td>
        <td style="width: 40%; border: 0; border-bottom: 1px solid #000; text-align: end; vertical-align : bottom">Лабзин И.И.</td>
    </tr>
    <tr style="border: 0">
        <td style="width: 15%; border: 0"></td>
        <td style="width: 40%; border: 0; text-align: center">подпись</td>
        <td style="width: 5%; border: 0"></td>
        <td style="width: 40%; border: 0; text-align: center">расшифровка подписи</td>
    </tr>
</table>
<table style="border: 0">
    <tr style="border: 0">
        <td style="width: 15%; border: 0; text-align: left; font-weight: bold">Главный бухгалтер</td>
        <td style="width: 40%; border: 0; border-bottom: 1px solid #000; text-align: center"><img height="60px" src="https://'.$_SERVER['HTTP_HOST'] . SITE_TEMPLATE_PATH.'/assets/images/labz.png" alt=""></td>
        <td style="width: 5%; border: 0"></td>
        <td style="width: 40%; border: 0; border-bottom: 1px solid #000; vertical-align : bottom">Лабзин И.И.</td>
    </tr>
    <tr style="border: 0">
        <td style="width: 30%; border: 0"></td>
        <td style="width: 25%; border: 0; text-align: center">подпись</td>
        <td style="width: 5%; border: 0"></td>
        <td style="width: 40%; border: 0; text-align: center">расшифровка подписи</td>
    </tr>
</table>
<table style="border: 0">
    <tr style="border: 0">
        <td style="width: 15%; border: 0; text-align: left; font-weight: bold">
        <img height="100px" src="https://'.$_SERVER['HTTP_HOST'] . SITE_TEMPLATE_PATH.'/assets/images/print_v2.png" alt="">
</td>
      
    </tr>
  
</table>
</body>
</html>');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $pdf = $dompdf->output();

    file_put_contents("./bill" . $arResult["ORDER_ID"] . ".pdf", $pdf);
    ?>
            <a id="payBill" class="button button-black"
       href="/personal/order/bill<?= $arResult["ORDER_ID"] ?>.pdf" target="_blank">Оплатить по
        счету</a>
<?php else: ?>
<div class="all__btn">
    <a class="button button-black" href="<?= SITE_DIR ?>catalog/">Продолжить покупки</a>
    <a class="button button-bord2" href="<?= SITE_DIR ?>">На главную</a>
    <?php endif; ?>
    <?
    //remove document after 6 month
    global $APPLICATION;
    $curDir = $_SERVER["DOCUMENT_ROOT"] . $APPLICATION->GetCurDir();
    foreach (scandir($curDir) as $obj) {
        if (explode(".", $obj)[1] == "pdf") {
            $file = $_SERVER["DOCUMENT_ROOT"] . $APPLICATION->GetCurDir() . $obj;
            $timeCreate = date("l jS \of F Y h:i:s A", filemtime($file));
            $timeNow = date(time());

            $difference = time() - filemtime($file); //seconds
            if ($difference > 15552000) unlink($file);
        }
    }
    //redirect to pdf
    if($_GET["TO_PDF"] == true){
//        header("location: /personal/order/bill" . $arResult["ORDER_ID"] . ".pdf");
    }
    ?>

