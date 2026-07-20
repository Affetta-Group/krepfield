<? require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"; ?>
<?php

use \Bitrix\Main\Application,
    \Bitrix\Main\Loader,
    \Bitrix\Main\Mail\Event as Mail,
    \Bitrix\Highloadblock as HL,
    \Bitrix\Main\Entity,
    \Bitrix\Main\Type\DateTime;

global $USER;
define('TOKENEXPIRED', 15);

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */
class afAuthController
{
    private function register($request, $type = '')
    {
        $name = $request->getPost("NAME");
        $suname = $request->getPost("SUNAME");

        $email = $request->getPost("EMAIL");
        if (empty($email)) {
            echo json_encode(["status" => false, 'errors' => 'Почта - обязятельное поле!!']);
            die;
        }

        $phone = $request->getPost("PHONE");
        $phone = preg_replace("/[^+0-9]/", '', $phone);
        if (empty($phone)) {
            echo json_encode(["status" => false, 'errors' => 'Телефон - обязятельное поле!!']);
            die;
        }
        $arFields = array(
            "NAME" => $name,
            "LAST_NAME" => $suname,
            "EMAIL" => $email,
            "PHONE_NUMBER" => $phone,
            "PERSONAL_PHONE" => $phone,
            "LOGIN" => $phone,
            "LID" => "ru",
            "ACTIVE" => "Y",
            "UF_PROMO_BLOCK" => false
        );
        if ($type == 'PROF') {
            $arFields['UF_PROMO_TYPE'] = 12; //ur

            $arFields['UF_UTM_SOURCE'] = $request->getPost("utm_source");
            $arFields['UF_UTM_CAMPAIGN'] = $request->getPost("utm_campaign");

            $obEnum = new CUserFieldEnum;
            $rsEnum = $obEnum->GetList(array(), array("USER_FIELD_ID" => '104'));
            while ($arEnum = $rsEnum->GetNext()) {
                if ($arEnum['XML_ID'] == $arFields['UF_UTM_SOURCE']) {
                    $arFields['UF_FROM'] = $arEnum['ID'];
                    break;
                }
            }
            $rsEnum = $obEnum->GetList(array(), array("USER_FIELD_ID" => '107'));
            while ($arEnum = $rsEnum->GetNext()) {
                if ($arEnum['XML_ID'] == $arFields['UF_UTM_CAMPAIGN']) {
                    $arFields['UF_CAMPAIGN'] = $arEnum['ID'];
                    break;
                }
            }
        }

        if ($type == 'CODE') {
            $arFields['UF_PROMO_TYPE'] = 13; //fz
            $promocode = $request->getPost("PROMOCODE");
            $promoCode = $this->checkPromoCode($promocode);
        }

        $phoneRecord = Bitrix\Main\UserPhoneAuthTable::getList([
            'filter' => [
                '=PHONE_NUMBER' => $phone
            ],
            'select' => ['USER_ID'],
        ])->fetchObject();

        if ($phoneRecord) {
            echo json_encode(["status" => false, 'errors' => 'Пользователь с таким номером телефона уже существует!!']);
            die;
        }

        //регистрируем нового пользователя
        $password = randString(7);

        $user = new CUser;

        $arFields["PASSWORD"] = $password;
        $arFields["CONFIRM_PASSWORD"] = $password;

        $user_id = $user->Add($arFields);
        if (intval($user_id) > 0) {
            // echo "Пользователь успешно добавлен.";
            $tg_message = "Ссылка: https://krepfield.ru/bitrix/admin/user_edit.php?lang=ru&ID=$user_id\nИмя пользователя: $name\nID ползователя: $user_id";
            if ($type == 'PROF') $this->sendTgMessage($GLOBALS['telegram_bot_token'], "-949712179", $tg_message);

            if ($promoCode) {
                $this->promoCodeUse($promoCode, $user_id);
            }

        } else {
            echo json_encode(["status" => false, 'errors' => $user->LAST_ERROR]);
            die;
        }

//        if ($type == 'PROF') {
        global $USER;
        $USER->Authorize($user_id);
        echo json_encode(["status" => true, 'authorized' => true]);
//        } else {
//            $this->sendCode($phone, 'SMS_USER_CONFIRM_NUMBER', $user_id);
//        }
    }

    private function sendTgMessage($token, $chatId, $message)
    {
        $website = "https://api.telegram.org/bot" . $token;
        //$chatId = '';  //** ===>>>NOTE: this chatId MUST be the chat_id of a person, NOT another bot chatId !!!**
        $params = [
            'chat_id' => $chatId,
            'text' => $message,
        ];
        $ch = curl_init($website . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    private function auth($request)
    {
        $phone = $request->getPost("PHONE");
        $phone = preg_replace("/[^+0-9]/", '', $phone);

        if (empty($phone)) {
            echo json_encode(["status" => false, 'errors' => 'Телефон - обязятельное поле!!']);
            die;
        }

        $phoneRecord = Bitrix\Main\UserPhoneAuthTable::getList([
            'filter' => [
                '=PHONE_NUMBER' => $phone
            ],
            'select' => ['USER_ID'],
        ])->fetchObject();

        if (!$phoneRecord) {
            echo json_encode(["status" => false, 'errors' => 'Пользователя с этими данными не существует - зарегистрируйтесь!!']);
            die;
        }

//        rdd($phoneRecord->get('USER_ID'),true);

        $this->sendCode($phone, 'SMS_USER_CONFIRM_NUMBER', $phoneRecord->get('USER_ID'));
    }

    private function sendCode($phone, $smsTemplate, $userId)
    {
        $result = \CUser::SendPhoneCode($phone, $smsTemplate, SITE_ID);
        if ($result->isSuccess()) {
            $arResult['SIGNED_DATA'] = \Bitrix\Main\Controller\PhoneAuth::signData([
                'phoneNumber' => $phone,
                'smsTemplate' => $smsTemplate
            ]);
            echo json_encode(["status" => true, 'authorized' => false]);
        } else {
//                echo json_encode(["errors" => $result->getErrorMessages()]);
            echo json_encode(["errors" => ["Оправить смс в данный момент невозможно\n<a href=\"javascript:void(0);\" onclick=\"window.promoReg.sendCodeByMail($userId);\">Отправить код на почту?</a>"]]);
        }
    }

    private function promoCodeUse($promoCode, $user_id)
    {
        Loader::includeModule("highloadblock");

        $hlblock_ID = HL\HighloadBlockTable::getList(array(
            'select' => array('ID'),
            'filter' => array('=NAME' => 'AffettaPromoCodes'),
            'limit' => 1,
        ))->fetch();

        if (empty($hlblock_ID['ID'])) {
            echo json_encode(["status" => false, 'errors' => 'highload блок не найден!!']);
            die;
        }

        $hlblock = HL\HighloadBlockTable::getById($hlblock_ID['ID'])->fetch();

        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $data = array(
            "UF_USER_ID" => $user_id,
            "UF_USER_USED_CODE_DATE" => new DateTime()
        );
        $entity_data_class::update($promoCode['ID'], $data);

        $user = new CUser;
        $fields = array(
            "UF_PROMO_CASH" => $promoCode['UF_CODE_CASH'],
            "UF_PROMO_EXEC" => true,
        );
        $user->Update($user_id, $fields);
    }

    private function checkPromoCode($promocode)
    {
        if (empty($promocode)) {
            echo json_encode(["status" => false, 'errors' => 'Промокод - обязятельное поле!!']);
            die;
        }

        Loader::includeModule("highloadblock");

        $hlblock_ID = HL\HighloadBlockTable::getList(array(
            'select' => array('ID'),
            'filter' => array('=NAME' => 'AffettaPromoCodes'),
            'limit' => 1,
        ))->fetch();

        if (empty($hlblock_ID['ID'])) {
            echo json_encode(["status" => false, 'errors' => 'highload блок не найден!!']);
            die;
        }

        $hlblock = HL\HighloadBlockTable::getById($hlblock_ID['ID'])->fetch();

        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $rsData = $entity_data_class::getList(array(
            "select" => array("*"),
            "order" => array("ID" => "ASC"),
            "filter" => array("UF_CODE" => $promocode)
        ));

        if ($arData = $rsData->Fetch()) {
            if (empty($arData['UF_USER_ID'])) {
                return $arData;
            } else {
                echo json_encode(["status" => false, 'errors' => 'Промокод уже использован!!']);
                die;
            }
        } else {
            echo json_encode(["status" => false, 'errors' => 'Промокод не найден!!']);
            die;
        }
    }

    private function sendCodeByMail($request)
    {
        $response = (object)[];

        $userId = $request->getPost("USER_ID");
        $rsUser = CUser::GetByID($userId);
        $arUser = $rsUser->Fetch();

        $code = rand(1111, 9999);
        $user = new CUser;
        $fields = array(
            "UF_SMSRU_CODE" => $code,
            "UF_SMSRU_CODE_DATE" => new DateTime(),
        );
        $user->Update($userId, $fields);

        $res = CEvent::Send("AUTH_CODE", SITE_ID, array(
            "EMAIL_TO" => $arUser['EMAIL'],
            "CODE" => $code
        ));

        $response->status = true;
        $response->authorize = false;
        $response->email = $arUser['EMAIL'];
        $response->result = $res;

        echo json_encode($response);
    }

    public function exec()
    {
        CJSCore::Init('phone_auth');
        $request = Application::getInstance()->getContext()->getRequest();
        $event = $request->getPost("EVENT");
        switch ($event) {
            case 'REGISTER':
                $this->register($request);
                break;
            case 'REGISTER_PROF':
                $this->register($request, 'PROF');
                break;
            case 'REGISTER_CODE':
                $this->register($request, 'CODE');
                break;
            case 'SEND_CODE':
                $this->auth($request);
                break;
            case 'mailCode':
                $this->sendCodeByMail($request);
                break;
            default:
                echo json_encode(["errors" => ["Неизвестный метод"]]);
                break;
        }
    }
}

$app = new afAuthController;
$app->exec();

?>
<? require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"; ?>
