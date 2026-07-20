<?php

function dd ($var, $force = false) {
    global $USER;
    if ($USER->IsAdmin() || $force) {
        echo '<pre>';
        echo htmlspecialchars(print_r($var, true));
        echo '</pre>';
        die;
    }
}

function d ($var, $force = false) {
    global $USER;
    if ($USER->IsAdmin() || $force) {
        echo '<pre>';
        echo htmlspecialchars(print_r($var, true));
        echo '</pre>';
    }
}

function rdd ($var, $force = false) {
    global $APPLICATION;
    global $USER;
    if ($USER->IsAdmin() || $force) {
        $APPLICATION->RestartBuffer();
        echo '<pre>';
        echo htmlspecialchars(print_r($var, true));
        echo '</pre>';
        die;
    }
}

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");