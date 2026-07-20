<?php

namespace Custom;

use Bitrix\Main\Application,
    Bitrix\Main\Loader,
    Bitrix\Main\Mail\Event,
    CBitrixComponent,
    CFile,
    CIBlockElement;

class Form extends CBitrixComponent
{
    public function executeComponent()
    {
        global $APPLICATION;

        $request = Application::getInstance()->getContext()->getRequest();

        if ($request->getPost("TOKEN") === $this->arParams["TOKEN"]) {
            $APPLICATION->RestartBuffer();

            $post_list = $request->getPostList()->toArray();
            $file_list = $request->getFileList()->toArray();
            $props = array_merge($post_list, $file_list);

            if ($this->arParams["RECAPTCHA_ENABLED"] === 'Y') {
                if (!$this->recaptcha($post_list["RECAPTCHA"])) {
                    $this->out([
                        "status" => false,
                        "message" => "Не пройдена проверка reCAPTCHA"
                    ]);
                }
            }

            $available_props = $this->arParams["PROPS"];
            $iblock_id = $this->arParams["IBLOCK_ID"];
            $save_r = $this->save($iblock_id, $props, $available_props);
            $iblock_el_id = $save_r["ID"];

            if ($save_r["status"] === false) {
                $this->out($save_r);
            }

            $db_list = CIBlockElement::GetList(
                ["SORT" => "ASC"],
                [
                    "IBLOCK_ID" => $iblock_id,
                    "ID" => $iblock_el_id
                ]
            );

            if ($db_el = $db_list->GetNextElement()) {
                $iblock_el_props = $db_el->GetProperties();
                $iblock_el_fields = $db_el->GetFields();

                $event_params = [
                    "EVENT_NAME" => $this->arParams["MAIL_EVENT"],
                    "LID" => SITE_ID,
                    "C_FIELDS" => [
                        "EMAIL_TO" => $this->arParams["EMAIL_TO"],
                        "EMAIL_FROM" => $this->arParams["EMAIL_FROM"],
                        "ELEMENT_ID" => $iblock_el_fields['ID'],
                        "FORM_NAME" => $this->arParams["FORM_NAME"]
                    ]
                ];

                foreach ($iblock_el_props as $code => $prop) {
                    $event_params["C_FIELDS"][$code] = $prop["VALUE"];

                    if ($prop["PROPERTY_TYPE"] === "F") {
                        $tag = CFile::GetPath($prop["VALUE"]);
                        $event_params["C_FIELDS"][$code] = $tag;
                        continue;
                    }

                    if(empty($prop["VALUE"])) continue;

                    $properties = \CIBlockProperty::GetList(array("sort" => "asc", "name" => "asc"),
                        array(
                            "ACTIVE" => "Y",
                            "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
                            "CODE" => $code,
                        )
                    );

                    if ($prop_fields = $properties->GetNext()) {
                        if($code == 'PHONE') {
                            $prop["VALUE"] = str_replace(" ","",$prop["VALUE"]);
                            $prop["VALUE"] = str_replace("(","",$prop["VALUE"]);
                            $prop["VALUE"] = str_replace(")","",$prop["VALUE"]);
                            $prop["VALUE"] = str_replace("-","",$prop["VALUE"]);
                        }

                        $event_params["C_FIELDS"]["FIELDS"] .= $prop_fields["NAME"].": ".$prop["VALUE"]."<br>";
                    }
                }

                Event::send($event_params);

                $tg_message = $event_params["C_FIELDS"]["FORM_NAME"]."\n\n".str_replace("<br>","\n",$event_params["C_FIELDS"]["FIELDS"]);
                $tg_answer = $this->sendTelegram($this->arParams['TELEGRAM_BOT_TOKEN'], $this->arParams['TELEGRAM_CHAT_ID'], $tg_message);
            }

            $this->out(["status" => true, "message" => "Форма успешно отправлена", "tg_answer" => $tg_answer]);
        }

        $this->includeComponentTemplate();
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

    protected function save($iblock_id, $props, $available_props)
    {

        if (!Loader::includeModule("iblock")) {
            return [
                "status" => false,
                "message" => "Не удалось подключить модуль 'iblock'"
            ];
        };

        $el = new CIBlockElement;
        $fields = [
            "NAME" => !empty($this->arParams["FORM_NAME"]) ? $this->arParams["FORM_NAME"] : "Форма",
            "IBLOCK_ID" => $iblock_id,
            "PROPERTY_VALUES" => []
        ];
        if (isset($this->arParams["ACTIVE"])) {
            $fields["ACTIVE"] = $this->arParams["ACTIVE"];
        }
        foreach ($props as $key => $prop) {
            if (in_array($key, $available_props)) {
                $fields["PROPERTY_VALUES"][$key]["VALUE"] = $prop;
            } else if (in_array("$key,TEXT", $available_props)) {
                $fields["PROPERTY_VALUES"][$key]["VALUE"] = [
                    "TYPE" => "TEXT",
                    "TEXT" => $prop
                ];
            } else if (in_array("$key,HTML", $available_props)) {
                $fields["PROPERTY_VALUES"][$key]["VALUE"] = [
                    "TYPE" => "HTML",
                    "TEXT" => $prop
                ];
            } else if (in_array("$key,FILE", $available_props)) {
                $fields["PROPERTY_VALUES"][$key] = $_FILES[$key];
            } else if (in_array("$key,FILES", $available_props)) {
                $fields["PROPERTY_VALUES"][$key] = $this->normalizeFiles($_FILES[$key]);
            }
        }
        $id = $el->Add($fields);

        if ($id === false) {
            return [
                "status" => false,
                "message" => "Не удалось создать элемент",
                "LAST_ERROR" => $el->LAST_ERROR
            ];
        }

        return [
            "status" => true,
            "message" => "Элемент успешно создан",
            "ID" => $id
        ];
    }

    protected function normalizeFiles($vector)
    {
        $result = [];

        foreach ($vector as $key1 => $value1) {
            foreach ($value1 as $key2 => $value2) {
                $result[$key2][$key1] = $value2;
            }
        }

        return $result;
    }

    protected function out($output): void
    {
        echo json_encode($output);
        exit();
    }
}