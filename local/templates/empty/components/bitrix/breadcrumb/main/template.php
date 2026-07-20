<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if (empty($arResult))
    return "";

$strReturn = '';
$strReturn .= '<div class="breadcrumb-block">
          <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';
$itemSize = count($arResult);
for ($index = 0; $index < $itemSize; $index++) {
    if ($arResult[$index]["LINK"] !== '/catalog/_kf/' && $arResult[$index]["LINK"] !== '/catalog/produktsiya/'){
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
    if ($arResult[$index]["LINK"] <> "" && $index != $itemSize - 1) {
        $strReturn .= '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . $arResult[$index]["LINK"] . '"><span itemprop="name">' . $title . '</span></a><meta itemprop="position" content="'.($index+1).'" /></li>';
    } else {
        $strReturn .= '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . $title . '</span><meta itemprop="position" content="'.($index+1).'" /></li> ';
    }
}
}
$strReturn .= '</ol>
      </div>';
return $strReturn;
