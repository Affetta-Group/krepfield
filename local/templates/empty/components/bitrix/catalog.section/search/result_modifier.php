<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var $arResult
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
if(is_array($arParams['ELEMENT_SORT_ORDER'])){
    $sorts = array_flip($arParams['ELEMENT_SORT_ORDER']);}else{
        $sorts = $arParams['ELEMENT_SORT_ORDER'];
}
usort($arResult['ITEMS'], function ($a, $b) use ($sorts) {
    return (int)$sorts[$a['ID']]-(int)$sorts[$b['ID']];
});
foreach ($arResult['ITEMS'] as $key => $arItem) {
    $arResult['ITEMS_BY_GROUP'][$arItem['IBLOCK_SECTION_ID']][] = $key;
}
//ksort($arResult['ITEMS_BY_GROUP']);
foreach ($arResult['ITEMS_BY_GROUP'] as $key => $section) {
    $db_list = CIBlockSection::GetList(
        array(),
        array("ID" => $key, "IBLOCK_ID" => $arParams["IBLOCK_ID"]),
        false,
        array("ID", "IBLOCK_ID", "NAME", "UF_*")
    );
    while ($db_el = $db_list->GetNext()) {
        $arResult['ITEMS_BY_GROUP']['SECTIONS'][] = $db_el;
    }
}
