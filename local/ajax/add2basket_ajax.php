<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include.php");

if (CModule::IncludeModule("sale") && CModule::IncludeModule("catalog")) {
    if (isset($_POST['PRODUCT_ID'], $_POST['QUANTITY'])) {
        $PRODUCT_ID = (int)$_POST['PRODUCT_ID'];
        $QUANTITY = (int)$_POST['QUANTITY'];
        $result = Add2BasketByProductID(
            $PRODUCT_ID,
            $QUANTITY,
            false
        );

        echo json_encode(["status" => (bool)$result], JSON_THROW_ON_ERROR);

    }
} else {
    echo "Не подключены модули";
}