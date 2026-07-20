<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

/**
 * Получаем все родительские секции, до текущей от корня
 * @param $section_id
 */
//function getParentSections($section_id){
//
//    $result = array();
//
//    $nav = CIBlockSection::GetNavChain(false, $section_id);
//    while($v = $nav->GetNext()) {
//
//        if($v['ID']) {
//            $result[] = $v['ID'];
//        }
//    }
//
//    return $result;
//}

if($USER->IsAdmin()){
    $dbSec = CIBlockSection::GetList([], ["ID" => $arResult["IBLOCK_SECTION_ID"]], false );
    while ($sec = $dbSec->GetNextElement()) {
    }



$arFilter = ["ID" => $arResult["IBLOCK_SECTION_ID"]];
$db_list = CIBlockSection::GetList(Array("timestamp_x"=>"DESC"), $arFilter, false, Array("UF_BANNER"));
  if($uf_value = $db_list->GetNext()):
  endif;
}
