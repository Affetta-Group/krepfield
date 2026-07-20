<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$config = require __DIR__.'/config.php';
require_once __DIR__.'/functions.php';
$catalogIblockId = (int)$config['CATALOG_IBLOCK_ID'];
$elasticIndex = $config['INDEX'];
$elasticPropertiesCodes = $config['PROPERTIES']??[];

$os = openSearchConnect($config, [CURLOPT_TIMEOUT=>30]);

$properties = [];
if (!empty($elasticPropertiesCodes)) {
    foreach ($elasticPropertiesCodes as $propertyCode=>$propertyParams) {
        $res = CIBlockProperty::GetList([], ['CODE'=>$propertyCode, 'IBLOCK_ID'=>$catalogIblockId]);
        if ($res->SelectedRowsCount() > 0) {
            $properties[$propertyCode] = $res->Fetch();
        }
    }
}

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
if (isset($_GET['refresh'])) {
    $mapping = [
        'properties'=>[
            'name_for_search'=>[
                'type'=>'text',
            ],
            'name'=>[
                'type'=>'text',
                'fields'=>[
                    'key'=>[
                        'type'=>'keyword'
                    ]
                ]
            ],
            'type'=>[
                'type'=>'text',
                'analyzer'=>'russian'
            ],
            'sections' => [
                'type' => 'keyword',
            ],
            'quantity'=>[
                'type'=>'integer'
            ],
            'show_counter'=>[
                'type'=>'integer'
            ],
            'price' => [
                'type' => 'float'
            ],
            'updated'=>[
                'type'=>'integer'
            ]
        ]
    ];
    if (!empty($elasticPropertiesCodes)) {
        foreach ($elasticPropertiesCodes as $propertyCode=>$propertyParams) {
            if (isset($properties[$propertyCode])) {
                $property = $properties[$propertyCode];
                $elasticKey = $property['CODE'];
                $elasticType = 'keyword';
                switch ($property['PROPERTY_TYPE']) {
                    case 'N':
                        $elasticType = 'integer';
                        break;
                    case 'L':
                        $elasticType = 'keyword';
                        break;
                }
                if (!empty($propertyParams['elastic_type'])) {
                    $elasticType = $propertyParams['elastic_type'];
                }

                $elasticFieldMap = [
                    'type'=>$elasticType
                ];
                if ($elasticType !== 'keyword') {
                    $elasticFieldMap['fields'] = [
                        'key' => [
                            'type' => 'keyword'
                        ],
                    ];
                }
                $mapping['properties'][$elasticKey] = $elasticFieldMap;
            }
        }
    }

    print_r($mapping);

    $params = [
        'index'=>$elasticIndex,
        'body'=>[
            'mappings'=> $mapping
        ]
    ];

    try {
        $exists = $os->indices()->get(['index'=>$elasticIndex]);
        $os->indices()->delete(['index'=>$elasticIndex]);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    $os->indices()->create($params);
}

$parents = [];
$sectionsNames = [];
$res = CIBlockSection::GetList(
    ['ID'],
    ['IBLOCK_ID' => $catalogIblockId, 'ACTIVE'=>'Y'],
    false,
    ['ID', 'IBLOCK_SECTION_ID', 'NAME']
);
while ($section = $res->getNext()) {
    $sectionId = (int)$section['ID'];
    $parents[$sectionId] = (int)$section['IBLOCK_SECTION_ID'];
    $sectionsNames[$sectionId] = $section['NAME'];
}

$propertiesIds = [];
foreach ($elasticPropertiesCodes as $propertyCode=>$propertyParams) {
    if (isset($properties[$propertyCode])) {
        $property = $properties[$propertyCode];
        $propertyId = (int)$property['ID'];
        $propertiesIds[] = $propertyId;
    }
}

$basePrice = \Bitrix\Catalog\GroupTable::getBasePriceType();
$selectFields = ['ID', 'IBLOCK_ID', 'NAME', 'QUANTITY', 'SHOW_COUNTER'];
if (!empty($basePrice)) {
    $selectFields[] = 'PRICE_'.$basePrice['ID'];
}
$res = CIBlockElement::GetList([], ['IBLOCK_ID'=>$catalogIblockId, 'ACTIVE'=>'Y'], false, false, $selectFields);
$count = (int)$res->SelectedRowsCount();
var_dump($count);
$updateTime = time();
$position = 0;
$items = [];
$sectionsReplaces = [
    'Болты'=>'Болт',
    'Шайбы'=>'Шайба',
    'Гайки'=>'Гайка',
    'Винты'=>'Винт',
    'Саморезы'=>'Саморез',
    'Заклепки'=>'Заклепка',
    'Наборы'=>'Набор',
    'Шпильки'=>'Шпилька',
    'Хомуты'=>'Хомут'
];
while ($item = $res->GetNext()) {
    ++$position;
    $itemId = (int)$item['ID'];

    $nameForSearch = $item['NAME'];
    if (preg_match('|M(\d+)х(\d+)|u', $nameForSearch, $matches) !== false) {
        if (!empty($matches[1])) {
            $nameForSearch .= ' м'.$matches[1];
        }
        if (!empty($matches[2])) {
            $nameForSearch .= ' '.$matches[2].'мм';
        }
    }
    if (preg_match('|(\d+) мм|u', $nameForSearch, $matches) !== false) {
        if (!empty($matches[1])) {
            $nameForSearch .= ' '.$matches[1].'мм';
        }
    }
    if (strpos(mb_strtolower($nameForSearch), 'сверло') !== false) {
        if (preg_match('|([\d,]+)х([\d,]+)|u', $nameForSearch, $matches) !== false) {
            if (!empty($matches[1])) {
                $nameForSearch .= ' '.$matches[1].'мм';
                $nameForSearch .= ' '.$matches[1].' мм';
            }
            if (!empty($matches[2])) {
                $nameForSearch .= ' '.$matches[2].'мм';
                $nameForSearch .= ' '.$matches[2].' мм';
            }
        }
    }

    $items[$itemId] = [
        'id'=>$itemId,
        'name'=>$item['NAME'],
        'name_for_search'=>$nameForSearch,
        'quantity'=>$item['QUANTITY'],
        'show_counter'=>$item['SHOW_COUNTER'],
        'updated'=>$updateTime
    ];

    $sections = CIBlockElement::GetElementGroups($itemId, true, ['ID']);
    while ($section = $sections->GetNext()) {
        $currentSectionID = $section['ID'];
        $items[$itemId]['sections'][] = (int)$currentSectionID; // В индексе были как строкой, так числом без приведения типа

        // Добавляем в индекс родительские разделы, для отображения в верхних разделах каталога
        while ($parents[$currentSectionID]) {
            $currentSectionID = $parents[$currentSectionID];
            $items[$itemId]['sections'][] = (int)$currentSectionID;
        }
    }
    $items[$itemId]['sections'] = array_unique($items[$itemId]['sections']);
    foreach ($items[$itemId]['sections'] as $sectionId) {
        if (isset($sectionsNames[$sectionId])) {
            $sectionName = $sectionsNames[$sectionId];
            $items[$itemId]['type'][] = $sectionName;
            if (isset($sectionsReplaces[$sectionName])) {
                $items[$itemId]['type'][] = $sectionsReplaces[$sectionName];
            }
        }
    }

    $items[$itemId]['price'] = 0;
    if (!empty($basePrice) && !empty($item['PRICE_'.$basePrice['ID']])) {
        $items[$itemId]['price'] = $item['PRICE_'.$basePrice['ID']];
    }

    $params = [
        'index'=>$elasticIndex,
        'body'=>[]
    ];

    if ($position === $count || count($items) >= 300) {
        //Добавить значения свойств
        if (!empty($propertiesIds)) {
            $itemsProperties = array_fill_keys(array_keys($items), []);
            CIBlockElement::GetPropertyValuesArray(
                $itemsProperties,
                $catalogIblockId,
                ['ID'=>array_keys($items)],
                [
                    'ID'=>$propertiesIds
                ]);

            foreach ($items as $itemId=>$item) {
                foreach ($elasticPropertiesCodes as $propertyCode=>$propertyParams) {
                    if (!empty($itemsProperties[$itemId][$propertyCode]['VALUE'])) {
                        $value = $itemsProperties[$itemId][$propertyCode]['VALUE'];
                        if (!empty($propertyParams['export_convert'])) {
                            $value = $propertyParams['export_convert']($value);
                        }
                        $items[$itemId][$propertyCode] = $value;
                        /*if ($propertyParams['elastic_type'] !== 'keyword') {
                            $items[$itemId][$propertyCode.'.key'] = $value;
                        }*/
                    }
                }
            }
        }

        foreach ($items as $itemId=>$item) {
            $params['body'][] = [
                'index' => [
                    '_index'=>$elasticIndex,
                    '_id'=>$item['id']
                ]
            ];
            unset($item['id']);

            $params['body'][] = $item;
        }
        try {
            $result = $os->bulk($params);
        } catch (\OpenSearch\Common\Exceptions\NoNodesAvailableException $e) {
            $error = SITE_SERVER_NAME.': NoNodesAvailableException in export.php: '.$e->GetMessage();
            IexSendTelegramError($error);
            echo $error;
            exit;
        } catch (Exception $e) {
            $error = SITE_SERVER_NAME.': OpenSearchError in export.php: '.$e->GetMessage();
            IexSendTelegramError($error);
            echo $error;
            exit;
        }

        if ($result['errors']) {
            foreach ($result['items'] as $item) {
                if (!empty($item['index']['error'])) {
                    echo 'ID '.$item['index']['_id'].': ('.$item['index']['error']['type'].') '.$item['index']['error']['reason']."\n";
                }
            }
        }
        $items = [];
    }
}

$result = $os->search([
    'index'=>$config['INDEX'],
    'body'=>[
        'query'=>[
            'bool'=>[
                'filter'=>[
                    'range'=>[
                        'updated'=>[
                            'lt'=>$updateTime
                        ]
                    ]
                ]
            ]
        ]
    ]
]);
foreach ($result['hits']['hits'] as $hit) {
    $os->delete([
        'index' => $elasticIndex,
        'id' => (int)$hit['_id'],
    ]);
}
