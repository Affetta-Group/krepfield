<? require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"; ?>
<?php

use \Bitrix\Main\Application,
	\Bitrix\Main\Mail\Event,
	Bitrix\Highloadblock\HighloadBlockTable as HLBT;

const MY_HL_BLOCK_ID = 5;
$request = Application::getInstance()->getContext()->getRequest();

if (!empty($request->getPost("EMAIL"))) {

	CModule::IncludeModule('highloadblock');

	function GetEntityDataClass($HlBlockId)
	{
		if (empty($HlBlockId) || $HlBlockId < 1) {
			return false;
		}
		$hlblock = HLBT::getById($HlBlockId)->fetch();
		$entity = HLBT::compileEntity($hlblock);
		$entity_data_class = $entity->getDataClass();
		return $entity_data_class;
	}

	$entity_data_class = GetEntityDataClass(MY_HL_BLOCK_ID);
	$rsData = $entity_data_class::getList(array(
		'select' => array('*'),
		'filter' => array("UF_EMAIL" => $request->getPost("EMAIL"))
	));
	if (!intval($rsData->getSelectedRowsCount())) {
		$result = $entity_data_class::add(array(
			'UF_EMAIL' => $request->getPost("EMAIL"),
		));
		if ($result) {
			$arPostFields = array(
				"EMAIL" => $request->getPost("EMAIL"),
			);
			CEvent::SendImmediate("MAIL_SENDED", "s1", $arPostFields);
			$arResult['MESSAGE'] = 'success';
		}
	} else {
		$arResult['MESSAGE'] = 'Вы уже подписаны на рассылку';
	}
	echo json_encode(["message" => $arResult['MESSAGE']]);
}
?>
<? require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"; ?>