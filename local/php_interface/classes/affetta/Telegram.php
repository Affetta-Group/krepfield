<?php

class Telegram
{
    static function sendTelegram($token, $chatId, $message) {
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
}