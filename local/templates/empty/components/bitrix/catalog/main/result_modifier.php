<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

/* @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 */


if (!empty($arResult["VARIABLES"]["SECTION_ID"]) || !empty($arResult["VARIABLES"]["SECTION_CODE"])) {
	$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);

	if (!empty($arResult['VARIABLES']['SECTION_ID'])) {
		$arFilter['ID'] = $arResult['VARIABLES']['SECTION_ID'];
	}

	if (!empty($arResult['VARIABLES']['SECTION_CODE'])) {
		$arFilter['CODE'] = $arResult['VARIABLES']['SECTION_CODE'];
	}

	$db_sections = CIBlockSection::GetList(
		array('SORT' => 'ASC'),
		$arFilter,
		true,
		array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'DEPTH_LEVEL', 'DESCRIPTION', 'UF_*')
	);

	if ($db_section = $db_sections->GetNext()) {
		$arResult['SECTION'] = $db_section;
	}
}
