<?php
//AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("MyClass", "OnBeforeIBlockElementUpdateHandler"));
//class MyClass
//{
//    public static function OnBeforeIBlockElementUpdateHandler(&$arFields)
//    {
//        if ($arFields['IBLOCK_ID'] == 10) {
//            if (empty($arFields['PROPERTY_VALUES'][92])) {
//                $arFields['PROPERTY_VALUES'][92] = 'Нет';
//                $arFields['ACTIVE'] = 'N';
//            } else {
//                foreach ($arFields['PROPERTY_VALUES'][92] as $item) {
//                    if (empty($item['VALUE'])) {
//                        $arFields['PROPERTY_VALUES'][92] = 'Нет';
//                        $arFields['ACTIVE'] = 'N';
//                    }
//                }
//            }
//
////            AddMessage2Log(print_r($arFields,true), "affetta");
//        }
//    }
//}

$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler( 'catalog', '\Bitrix\Catalog\Price::OnBeforeUpdate',
    static function (\Bitrix\Main\Event $event) {
        $data = $event->getParameter("fields");
        if ($data['PRICE'] == 0) {
            $arActive = Array("ACTIVE" => "N");
            $ibp = new CIBlockElement();
            $ibp->Update($data["PRODUCT_ID"], $arActive);
        }
//        AddMessage2Log(print_r($data,true), "affetta");
    }
);

$eventManager->addEventHandler('sale', 'OnSaleOrderSaved',
    static function (\Bitrix\Main\Event $event) {
        $order = $event->getParameter("ENTITY");
        $oldValues = $event->getParameter("VALUES");
        $isNew = $event->getParameter("IS_NEW");

        if ($isNew)
        {
            $sum = $order->getPrice();
            $userId = $order->getUserId();
            $orderId = $order->getId();
            $propertyCollection = $order->getPropertyCollection();

            $phoneProp = $propertyCollection->getPhone();
            $emailProp = $propertyCollection->getUserEmail();
            $payerName = $propertyCollection->getPayerName();

            $personType = $order->getPersonTypeId();
            if($personType == 1){
                $personType = "Физ. лицо";
            }else{
                $personType = "Юр. лицо - " . $propertyCollection->getItemByOrderPropertyCode("COMPANY_NAME")->getValue();
            }
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/test5.txt", $personType );

            $phone = $phoneProp->getValue();
            $email = $emailProp->getValue();
            $payerName = $payerName->getValue();

            $delivery = $order->getDeliveryIdList();
            $tg_mess = "Новый заказ на сайте krepfield.ru\nФИО: $payerName\nEmail: $email\nТелефон: $phone\nСумма заказа: $sum\nТип плательщика: $personType";
            Telegram::sendTelegram($GLOBALS['telegram_bot_token'], '-962707501', $tg_mess);
        }
    }
);

$eventManager->addEventHandler('sale', 'OnSaleOrderPaid',
    static function (\Bitrix\Main\Event $event) {
        $order = $event->getParameter("ENTITY");

        if ($order ->isPaid())
        {
            $sum = $order->getPrice();
            $userId = $order->getUserId();
            $orderId = $order->getId();
            $propertyCollection = $order->getPropertyCollection();
            $delivery = $order->getDeliveryIdList();

            $phoneProp = $propertyCollection->getPhone();
            $emailProp = $propertyCollection->getUserEmail();
            $payerName = $propertyCollection->getPayerName();

            $phone = $phoneProp->getValue();
            $email = $emailProp->getValue();
            $payerName = $payerName->getValue();

//            AddMessage2Log(print_r(get_class_methods($propertyCollection),true), "affetta");

            $tg_mess = "Оплачен заказ на сайте krepfield.ru\nФИО: $payerName\nEmail: $email\nТелефон: $phone\nСумма заказа: $sum";
            Telegram::sendTelegram($GLOBALS['telegram_bot_token'], '-962707501', $tg_mess);

//    Отправить смс сообщение пользователю после оплаты заказа с методом доставки "Самовывоз"

            if ($delivery[0] === 2) {
                $date  = date("d.m", strtotime('5 days'));
                $sms_mess = "Срок хранения заказа № $orderId до $date. Выдача по адресу: г. Москва, п. Московский, кв.63, д.1Б, стр.4 (склад №21) по предварительной записи +79251810438";

                $ch = curl_init("https://sms.ru/sms/send");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
                    "api_id" => "3EE035EA-36A1-D05C-F2F1-C13256AA7754",
                    "to" => $phone,
                    "msg" => $sms_mess,
                    "json" => 1,
                )));
                $body = curl_exec($ch);
                curl_close($ch);

                $json = json_decode($body);
                file_put_contents($_SERVER['DOCUMENT_ROOT'], $json);
            }
//    Отправить смс сообщение пользователю после оплаты заказа с методом доставки "Самовывоз"
        }
    }
);