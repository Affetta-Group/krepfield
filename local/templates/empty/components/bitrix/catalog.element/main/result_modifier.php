<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if (!empty($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])) {
    foreach ($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as &$photo) {
        $photo = [
            // 'src' => AffettaCFile::ResizeImageGet($photo, ["width" => 1000, "height" => 1000 ], false,false,false,false,['FILE_NAME_NEW' => $arResult['CODE']])['src']
            'src' => CFile::ResizeImageGet($photo, ["width" => 1000, "height" => 1000 ], false,false,false,false)['src']
            ];
    }
    unset($photo);
}

if (!empty($arResult["DETAIL_PICTURE"]["SRC"])) {
    $arResult["DETAIL_PICTURE"] =
        [
            // 'src' => AffettaCFile::ResizeImageGet($arResult['DETAIL_PICTURE']['ID'], ["width" => 1000, "height" => 1000 ], false,false,false,false,['FILE_NAME_NEW' => $arResult['CODE']])['src']
            'src' => CFile::ResizeImageGet($arResult['DETAIL_PICTURE']['ID'], ["width" => 1000, "height" => 1000 ], false,false,false,false)['src']
        ];
} else {
    $arResult["DETAIL_PICTURE"]["SRC"] = SITE_TEMPLATE_PATH . "/assets/images/svg/no-img.svg";
}

if (!empty($arResult["PROPERTIES"]["KF_DLYA_SAYTA_STANDART"]["VALUE"])) {
    $db_list = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "IBLOCK_SECTION_ID" => $arResult["IBLOCK_SECTION_ID"], ">CATALOG_PRICE_1" => 0, "ACTIVE" => 'Y', "CATALOG_AVAILABLE" => 'Y', 'PROPERTY_KF_DLYA_SAYTA_STANDART_VALUE' => $arResult["PROPERTIES"]["KF_DLYA_SAYTA_STANDART"]["VALUE"]),
        false,
        array(),
        array("ID", "ACTIVE", "IBLOCK_ID", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "NAME", "PROPERTY_KF_DLYA_SAYTA_NAIMENOVANIE", "PROPERTY_*")
    );
    while ($db_el = $db_list->GetNextElement()) {
        $arFields = $db_el->GetFields();
        if ((int)$arFields['ID'] !== $arResult['ID']) {

            if($arFields['ACTIVE'] != 'Y' || $arFields['CATALOG_AVAILABLE'] != 'Y') $arFields['DETAIL_PAGE_URL'] = 'javascript:void(0);';

            // if($arFields['PREVIEW_PICTURE']) $arFields['PREVIEW_PICTURE'] = AffettaCFile::ResizeImageGet($arFields['PREVIEW_PICTURE'], ["width" => 100, "height" => 100], false,false,false,false,['FILE_NAME_NEW' => $arFields["NAME"]])['src'];
            if($arFields['PREVIEW_PICTURE']) $arFields['PREVIEW_PICTURE'] = CFile::ResizeImageGet($arFields['PREVIEW_PICTURE'], ["width" => 100, "height" => 100], false,false,false,false)['src'];

            $arResult["PRODUCTS_OTHER_SIZE"]["FIELDS"][] = $arFields;

            $arResult["IDS"][] = $arFields['ID'];
            $arResult["PRODUCTS_OTHER_SIZE"]["PRICES"][] = CPrice::GetBasePrice((int)$arFields['ID']);
            $arResult["PRODUCTS_OTHER_SIZE"]["PROPS"][] = $db_el->GetProperties();
            $arResult["MATERIALS"][] = $db_el->GetProperties()["KF_DLYA_SAYTA_MATERIAL"]["VALUE"];
            $arResult["DIAMETERS"][] = $db_el->GetProperties()["KF_DLYA_SAYTA_DIAMETR"]["VALUE"];
            $arResult["LENGTHS"][] = $db_el->GetProperties()["KF_DLYA_SAYTA_DLINA"]["VALUE"];
        }
    }
}
if(is_array($arResult["MATERIALS"])){
    $arResult["MATERIALS"] = array_values(array_unique($arResult["MATERIALS"]));
    $arResult["MATERIALS"] = array_diff($arResult["MATERIALS"], array(''));
}
if(is_array($arResult["DIAMETERS"])){
    $arResult["DIAMETERS"] = array_values(array_unique($arResult["DIAMETERS"]));
    $arResult["DIAMETERS"] = array_diff($arResult["DIAMETERS"], array(''));
    }
if(is_array($arResult["LENGTHS"])){
    $arResult["LENGTHS"] = array_values(array_unique($arResult["LENGTHS"]));
    $arResult["LENGTHS"] = array_diff($arResult["LENGTHS"], array(''));
}

// Create name

$arResult['H1'] = !empty($arResult['PROPERTIES']['KF_DLYA_SAYTA_NAIMENOVANIE']['VALUE'])
    ? $arResult['PROPERTIES']['KF_DLYA_SAYTA_NAIMENOVANIE']['VALUE']
    : $arResult['NAME'];
$arResult['H1'] = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['H1'];

// Add alt and title for img

$arResult['DETAIL_PICTURE']['ALT'] = "{$arResult['H1']} купить";
$arResult['DETAIL_PICTURE']['TITLE'] = $arResult['H1'];

if ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE']) {
    $counter = 2;
    foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as &$pic) {
        $pic['ALT'] = "{$arResult['H1']} купить (рис. $counter)";
        $pic['TITLE'] = "{$arResult['H1']} (рис. $counter)";
        $counter++;
    }
}

function getSectionProperty($sectionId)

{
    $sections = CIBlockSection::GetList(["SORT" => "ASC"],
        ["IBLOCK_ID" => 10, "ACTIVE" => "Y", "ID" => $sectionId,],
        true,
        ["NAME", "ID", "UF_ARTICLE", "UF_VIDEO", "UF_VIDEO_NAME", "UF_FILE", "UF_FILE_NAME", "IBLOCK_SECTION_ID"],
        false);
    $property = [];

    while ($section = $sections->GetNext()) {
        $property[] = $section;
    }
    if ($property[0]['UF_ARTICLE'] || $property[0]['UF_VIDEO'] || $property[0]['UF_FILE']) {
        return $property;
    } else if ($property[0]['IBLOCK_SECTION_ID']) {
        return getSectionProperty($property[0]['IBLOCK_SECTION_ID']);
    }
}
$sectionId = $arResult["IBLOCK_SECTION_ID"]; // получили и записали id подраздела
$property = getSectionProperty($sectionId); // вытянули все значения кастомных полей разделов

foreach ($property as $value) {
    if ($value["ID"]) {
        foreach ($value["UF_ARTICLE"] as $k => $articlesId) {
            $article = CIBlockElement::GetByID($articlesId);
            if ($articlesId = $article->GetNext()) {
                $arResult['USEFUL']['ARTICLE'][$k]['NAME'] = $articlesId['NAME'];
                $arResult['USEFUL']['ARTICLE'][$k]['URL'] = $articlesId['DETAIL_PAGE_URL'];
            }
        }
        foreach ($value["UF_FILE"] as $k => $filesId) {
            $files = CFile::GetPath($filesId);
            $arResult['USEFUL']['FILES'][$k]['NAME'] = $value["UF_FILE_NAME"][$k] ? $value["UF_FILE_NAME"][$k] : 'Файл ' . ($k + 1);
            $arResult['USEFUL']['FILES'][$k]['URL'] = $files;
        }
        foreach ($value["UF_VIDEO"] as $k => $video) {
            $arResult['USEFUL']['VIDEOS'][$k]['NAME'] = $value["UF_VIDEO_NAME"][$k] ? $value["UF_VIDEO_NAME"][$k] : 'Видео ' . ($k + 1);
            $arResult['USEFUL']['VIDEOS'][$k]['URL'] = $video;
        }
    }
}