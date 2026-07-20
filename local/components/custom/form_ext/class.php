<?php

namespace Custom;

use Bitrix\Main\Application,
    Bitrix\Main\Loader,
    Bitrix\Main\Mail\Event,
    CBitrixComponent,
    CFile,
    CIBlockElement,
    Bitrix\Affettapromo\ClaimTable;

class Form_ext extends CBitrixComponent
{
    public function executeComponent()
    {
        global $APPLICATION, $USER;
        if (!Loader::includeModule('affettapromo')) return;

        $request = Application::getInstance()->getContext()->getRequest();

        if ($request->getPost("TOKEN") === $this->arParams["TOKEN"]) {
            $APPLICATION->RestartBuffer();

            $post_list = $request->getPostList()->toArray();
            $file_list = $request->getFileList()->toArray();

            if ($this->arParams["RECAPTCHA_ENABLED"] === 'Y') {
                if (!$this->recaptcha($post_list["RECAPTCHA"])) {
                    $this->out([
                        "status" => false,
                        "message" => "Не пройдена проверка reCAPTCHA"
                    ]);
                }
            }

            $validateProps = $this->validateProps(array_merge($post_list, $file_list));

            if ($USER->IsAuthorized()) {
                $validateProps['USER_ID'] = $USER->GetID();
                $save_r = $this->save($validateProps);
            } else {
                $save_r = $this->registerUser($validateProps);
            }



            if ($save_r["status"] === false) {
                $this->out($save_r);
            } else {
                $iblock_el_id = $save_r["ID"];
            }

//            $db_list = CIBlockElement::GetList(
//                ["SORT" => "ASC"],
//                [
//                    "IBLOCK_ID" => $iblock_id,
//                    "ID" => $iblock_el_id
//                ]
//            );
//
//            if ($db_el = $db_list->GetNextElement()) {
//                $iblock_el_props = $db_el->GetProperties();
//                $iblock_el_fields = $db_el->GetFields();
//
//                $event_params = [
//                    "EVENT_NAME" => $this->arParams["MAIL_EVENT"],
//                    "LID" => SITE_ID,
//                    "C_FIELDS" => [
//                        "EMAIL_TO" => $this->arParams["EMAIL_TO"],
//                        "EMAIL_FROM" => $this->arParams["EMAIL_FROM"],
//                        "ELEMENT_ID" => $iblock_el_fields['ID'],
//                        "FORM_NAME" => $this->arParams["FORM_NAME"]
//                    ]
//                ];
//
//                foreach ($iblock_el_props as $code => $prop) {
//                    $event_params["C_FIELDS"][$code] = $prop["VALUE"];
//
//                    if ($prop["PROPERTY_TYPE"] === "F") {
//                        $tag = CFile::GetPath($prop["VALUE"]);
//                        $event_params["C_FIELDS"][$code] = $tag;
//                        continue;
//                    }
//
//                    if(empty($prop["VALUE"])) continue;
//
//                    $properties = \CIBlockProperty::GetList(array("sort" => "asc", "name" => "asc"),
//                        array(
//                            "ACTIVE" => "Y",
//                            "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
//                            "CODE" => $code,
//                        )
//                    );
//
//                    if ($prop_fields = $properties->GetNext()) {
//                        if($code == 'PHONE') {
//                            $prop["VALUE"] = str_replace(" ","",$prop["VALUE"]);
//                            $prop["VALUE"] = str_replace("(","",$prop["VALUE"]);
//                            $prop["VALUE"] = str_replace(")","",$prop["VALUE"]);
//                            $prop["VALUE"] = str_replace("-","",$prop["VALUE"]);
//                        }
//
//                        $event_params["C_FIELDS"]["FIELDS"] .= $prop_fields["NAME"].": ".$prop["VALUE"]."<br>";
//                    }
//                }
//
//                Event::send($event_params);
//
//                $tg_message = $event_params["C_FIELDS"]["FORM_NAME"]."\n\n".str_replace("<br>","\n",$event_params["C_FIELDS"]["FIELDS"]);
//                $tg_answer = $this->sendTelegram($this->arParams['TELEGRAM_BOT_TOKEN'], $this->arParams['TELEGRAM_CHAT_ID'], $tg_message);
//            }

            $tg_answer = '';
            $this->out(["status" => true, "message" => "Форма успешно отправлена", "tg_answer" => $tg_answer]);
        }

        $this->includeComponentTemplate();
    }

    protected function validateProps($props) {
        $available_props = $this->arParams["PROPS"];
        foreach ($props as $key => $prop) {
            if (in_array($key, $available_props)) {
                $validateProps[$key] = $prop;
            }
        }
        return $validateProps;
    }

    protected function registerUser($props) {
        $user = new \CUser;
        $arFields = array(
            "NAME" => $props['NAME'],
            "EMAIL" => $props['MAIL'],
            "LOGIN" => $props['MAIL'],
            "PERSONAL_PHONE" => $props['PHONE'],
            "ACTIVE" => "Y",
            "PASSWORD" => "DeFaUlTpAss3929$#",
            "CONFIRM_PASSWORD" => "DeFaUlTpAss3929$#",
        );

        $ID = $user->Add($arFields);
        if (intval($ID) > 0)
            return [
                "status" => true,
                "message" => "Пользователь успешно добавлен!!",
            ];
        else
            return [
                "status" => false,
                "message" => "Ошибка!",
                "errror" => $user->LAST_ERROR
            ];
    }

    protected function sendTelegram($token, $chatId, $message) {
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

    protected function recaptcha($recaptcha)
    {
        $url = "https://www.google.com/recaptcha/api/siteverify?secret="
            . $this->arParams["RECAPTCHA_PRIVATE_KEY"]
            . "&response="
            . $recaptcha
            . "&remoteip="
            . $_SERVER["REMOTE_ADDR"];
        $response_data = file_get_contents($url);
        $response_json = json_decode($response_data, true);

        return $response_json["success"] && $response_json["score"] >= 0.5 && $response_json["action"] === "feedback";
    }

    protected function save($arParams)
    {
        $result = ClaimTable::add($arParams);

        if ($result->isSuccess()) {
            return [
                "status" => true,
                "message" => "Элемент успешно создан " . $result->getId(),
                "ID" => $result->getId()
            ];
        } else {
            $errors = $result->getErrors();
            foreach ($errors as $error)
                $err .= $error->getMessage() . "\n";

            return [
                "status" => false,
                "message" => "Ошибка!",
                "errror" => $err
            ];
        }
    }

    protected function out($output): void
    {
        echo json_encode($output);
        exit();
    }
}