<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @var array $arResult
 */
if($GLOBALS['ion']['UF_TOP_BANNER_MESSAGE_ACTIVE'] == "Y"){
?>
<div class="top-client-message">
    <div class="top-client-message__text">
        <?= $GLOBALS['ion']['UF_TOP_BANNER_MESSAGE_TEXT']?>
    </div>
</div>
<?php
}