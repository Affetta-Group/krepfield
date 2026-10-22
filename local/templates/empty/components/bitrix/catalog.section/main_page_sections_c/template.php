<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use  Bitrix\Main\Grid\Declension;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 *
 *  _________________________________________________________________________
 * |    Attention!
 * |    The following comments are for system use
 * |    and are required for the component to work correctly in ajax mode:
 * |    <!-- items-container -->
 * |    <!-- pagination-container -->
 * |    <!-- component-end -->
 */

$this->setFrameMode(true);
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');

if (!empty($arResult['NAV_RESULT'])) {
	$navParams = array(
		'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
		'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
		'NavNum' => $arResult['NAV_RESULT']->NavNum
	);
} else {
	$navParams = array(
		'NavPageCount' => 1,
		'NavPageNomer' => 1,
		'NavNum' => $this->randString()
	);
}

$sectId=array();
$sectId2=array();
$sects=array();
$arSelect = Array("ID", "NAME", "IBLOCK_SECTION_ID");
$arFilter = Array("IBLOCK_ID"=>10, "PROPERTY_KF_DLYA_SAYTA_KHIT" => "Да");
$resE = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
$count=0;
while($ob = $resE->GetNextElement())
{
	$count++;
	$arFields = $ob->GetFields();
	if(!in_array($arFields["IBLOCK_SECTION_ID"], $sectId)){
		$sectId[]=$arFields["IBLOCK_SECTION_ID"];
		$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
		if ($arSection = $res->GetNext()) {
			if(!in_array($arSection["IBLOCK_SECTION_ID"], $sectId2)){
				$res2 = CIBlockSection::GetByID($arSection["IBLOCK_SECTION_ID"]);
				$sectId2[]=$arSection["IBLOCK_SECTION_ID"];
				if ($arSection2 = $res2->GetNext()) {
					$sects[]=$arSection2;

				}
			}
		} 
}
}

$svg=CFile::GetPath(Ion\Settings::getSpaceField("UF_ICON_SVG_KHIT", "MAIN"));
$svg2=CFile::GetPath(Ion\Settings::getSpaceField("UF_ICON_SVG_KHIT2", "MAIN"));

$colorID=Ion\Settings::getSpaceField("UF_COLOR_KHIT", "MAIN");
if($colorID==64){
	$color="bg2";
}elseif($colorID==65){
	$color="bg3";
}elseif($colorID==66){
	$color="bg1";
}
elseif($colorID==68){
	$color="bg5";
}
// echo "<pre>Template arResult: "; print_r(Ion\Settings::getSpaceField("UF_COLOR_KHIT", "MAIN")); echo "</pre>";

?>

<div class="catalog-min__inner">

<div class="catalog-min__list">
        <ul>
			<?foreach($sects as $sect){?>
                            <li ><a href="<?= $sect["SECTION_PAGE_URL"] ?>filter/kf_dlya_sayta_khit-is-да/apply/"><?= $sect["NAME"]?></a></li>
                           <?}?>
                    </ul>
    </div>
	<div class="catalog-min__info <?= $color ?>">
        <div class="catalog-min__info-top">
            <div class="catalog-min__info-top-title">Хиты</div>
            <div class="catalog-min__info-top-nb">
                <span><?= $count?></span> <?= (new Declension('товар', 'товара', 'товаров'))->get($count) ?>            </div>
            <div class="catalog-min__info-top-icon"><img src="<?= $svg;?>" alt=""></div>
        </div>
        <div class="catalog-min__info-img" style="background-image: url('<?= $svg2;?>')"></div>
            <!-- style="background-image: url('')"></div> -->

    </div>

	<div class="catalog-min__cats">
<?
$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1) {
	$showTopPager = $arParams['DISPLAY_TOP_PAGER'];
	$showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
	$showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'];
}

$templateLibrary = array('popup', 'ajax', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES'])) {
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])) {
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos) {
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION'])) {
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos) {
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
	}
}

$arParams['~MESS_BTN_BUY'] = $arParams['~MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_BUY');
$arParams['~MESS_BTN_DETAIL'] = $arParams['~MESS_BTN_DETAIL'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_DETAIL');
$arParams['~MESS_BTN_COMPARE'] = $arParams['~MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_COMPARE');
$arParams['~MESS_BTN_SUBSCRIBE'] = $arParams['~MESS_BTN_SUBSCRIBE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE');
$arParams['~MESS_BTN_ADD_TO_BASKET'] = $arParams['~MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET');
$arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE');
$arParams['~MESS_SHOW_MAX_QUANTITY'] = $arParams['~MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCS_CATALOG_SHOW_MAX_QUANTITY');
$arParams['~MESS_RELATIVE_QUANTITY_MANY'] = $arParams['~MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['~MESS_RELATIVE_QUANTITY_FEW'] = $arParams['~MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_FEW');

$arParams['MESS_BTN_LAZY_LOAD'] = $arParams['MESS_BTN_LAZY_LOAD'] ?: Loc::getMessage('CT_BCS_CATALOG_MESS_BTN_LAZY_LOAD');

$generalParams = array(
	'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
	'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
	'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
	'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
	'MESS_SHOW_MAX_QUANTITY' => $arParams['~MESS_SHOW_MAX_QUANTITY'],
	'MESS_RELATIVE_QUANTITY_MANY' => $arParams['~MESS_RELATIVE_QUANTITY_MANY'],
	'MESS_RELATIVE_QUANTITY_FEW' => $arParams['~MESS_RELATIVE_QUANTITY_FEW'],
	'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
	'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
	'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
	'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
	'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
	'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
	'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'],
	'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
	'COMPARE_PATH' => $arParams['COMPARE_PATH'],
	'COMPARE_NAME' => $arParams['COMPARE_NAME'],
	'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
	'PRODUCT_BLOCKS_ORDER' => $arParams['PRODUCT_BLOCKS_ORDER'],
	'LABEL_POSITION_CLASS' => $labelPositionClass,
	'DISCOUNT_POSITION_CLASS' => $discountPositionClass,
	'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
	'SLIDER_PROGRESS' => $arParams['SLIDER_PROGRESS'],
	'~BASKET_URL' => $arParams['~BASKET_URL'],
	'~ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
	'~BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE'],
	'~COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
	'~COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
	'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
	'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY'],
	'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
	'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
	'MESS_BTN_COMPARE' => $arParams['~MESS_BTN_COMPARE'],
	'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
	'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
	'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE']
);

$obName = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($navParams['NavNum']));
$containerName = 'container-' . $navParams['NavNum'];
$count_prod = $arResult['NAV_RESULT']->NavRecordCount;

if ($showTopPager) {
	?>
	<div data-pagination-num="<?= $navParams['NavNum'] ?>">
		<!-- pagination-container -->
		<?= $arResult['NAV_STRING'] ?>
		<!-- pagination-container -->
	</div>
	<?
}
?>
<?php
$areaIds = array();

foreach ($arResult['ITEMS'] as $item) {
	$uniqueId = $item['ID'] . '_' . md5($this->randString() . $component->getAction());
	$areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
	$this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
	$this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
}
?>
	<div class="row items-list">
		<!-- items-container -->
		<?$i=0;
		foreach ($arResult['ITEM_ROWS'] as $rowData) {
			$rowItems = array_splice($arResult['ITEMS'], 0, $rowData['COUNT']);
			foreach ($rowItems as $item) {

				if($item["PROPERTIES"]["IS_MAIN"]["VALUE"]== "Да"){
				$i++;
				
				$APPLICATION->IncludeComponent(
					'bitrix:catalog.item',
					'catalog',
					array(
						'RESULT' => array(
							'ITEM' => $item,
							'AREA_ID' => $areaIds[$item['ID']],
							'TYPE' => $rowData['TYPE'],
							'BIG_LABEL' => 'N',
							'BIG_DISCOUNT_PERCENT' => 'N',
							'BIG_BUTTONS' => 'N'
						),
						'PARAMS' => $generalParams
							+ array('SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']])
							+ array('IS_FAVORITE' => in_array($item['ID'], $GLOBALS['FAVORITES']) ? 'Y' : 'N')
							+ array('CLASS_NAME' => $arParams['CLASS_NAME'])
					),
					$component,
					array('HIDE_ICONS' => 'Y')
				);
			}if($i>5) break;}
		}
		unset($generalParams, $rowItems);
		?>
		<!-- items-container -->
	</div>
<?

if ($showBottomPager) {
	?>
	<!-- pagination-container -->
<div class="catalog-page__content-tb-bottom">
    <?
    $plus = $navParams["NavPageNomer"] + 1;
    $url = $arResult["NAV_PARAM"]["NAV_PARAM"] . "?PAGEN_" . $navParams["NavNum"] . "=" . $plus;
    ?>
    <? if ($navParams["NavPageCount"] > 1): ?>
        <? if ($navParams["NavPageNomer"] + 1 <= $arResult['NAV_RESULT']->nEndPage): ?>
            <div class="catalog-page__content-tb-bottom-btn load-more-items" data-url="<?= $url ?>">
                Показать еще
            </div>
        <? endif ?>
    <? endif ?>
</div>
	<!-- pagination-container -->
	<?
}
?>
<?php
$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'catalog.section');
$signedParams = $signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');
?>
</div>
</div>