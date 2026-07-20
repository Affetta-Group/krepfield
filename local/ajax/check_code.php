<? require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"; ?>
<?php

use \Bitrix\Main\Application,
    \Bitrix\Main\Loader,
    \Bitrix\Main\Mail\Event;

global $USER;
define('TOKENEXPIRED', 15);

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

CJSCore::Init('phone_auth');
//echo json_encode(["errors" => 'Ошибка! Введен неверный код']);
function userPhoneCodeVerify($id, $code, $remember = false) {
    global $USER;
    $response = (object)[];

    $rsUsers = CUser::GetList(array('sort' => 'asc'), 'sort', ['ID' => $id], array('SELECT' => ['UF_SMSRU_CODE','UF_SMSRU_CODE_DATE']));
    $arUser = $rsUsers->Fetch();

    if(empty($arUser)) {
        $response->errors[] = "Пользователь с таким id не найден";
        echo json_encode($response);
        die;
    }

    if($arUser['UF_SMSRU_CODE_DATE']) {
        $seconds = time() - strtotime($arUser['UF_SMSRU_CODE_DATE']);
        $minutes = $seconds / 60;
        if ($minutes > TOKENEXPIRED) {
            $response->errors[] = "Время действия кода истекло";
            echo json_encode($response);
            die;
        }
    } else {
        $response->errors[] = "Сначала отправьте код";
        echo json_encode($response);
        die;
    }

    if($arUser['UF_SMSRU_CODE']) {
        if ($arUser['UF_SMSRU_CODE'] == $code) {
            if ($USER->Authorize($id, $remember)) {
                $response->succes_auth = true;
            } else {
                $response->errors[] = "Пользователь заблокирован";
                echo json_encode($response);
                die;
            }
        } else {
            $response->errors[] = "Код не верный";
            echo json_encode($response);
            die;
        }
    } else {
        $response->errors[] = "Сначала отправьте код";
        echo json_encode($response);
        die;
    }

    return true;
}

$request = Application::getInstance()->getContext()->getRequest();
$phone = $request->getPost("PHONE");
$phone = preg_replace("/[^+0-9]/", '', $phone);
$code = $request->getPost("CODE");

if (($userId = CUser::VerifyPhoneCode($phone, $code))) {
    $USER->Authorize($userId);
    echo json_encode(["status" => true, 'authorized' => true]);
    die;
} else {

    if (userPhoneCodeVerify($request->getPost("USER_ID"), $code)) {
        echo json_encode(["status" => true,'authorized' => true]);
        die;
    }

    echo json_encode(["status" => false,"errors" => 'Ошибка! Введен неверный код']);
    die;
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"; ?>