<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<? $APPLICATION->IncludeComponent(
    "affetta:ion_show_field",
    "new_year_header",
    Array(
        "HBLOCK_ID" => "7",
        "FIELDS" => ["UF_NEW_YEAR_HEADER"],
    )
); ?>
