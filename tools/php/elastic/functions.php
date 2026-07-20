<?php
require_once __DIR__.'/vendor/autoload.php';
function openSearchConnect($config) {
    $osUser = $config['USER']??'';
    $osPassword = $config['PASSWORD']??'';
    $osHost = $config['HOST']??'';
    $osPort = $config['PORT']??'';
    $osHttps = ($config['HTTPS']??0) > 0;
    $osCloudCertificate = $config['CLOUD_CERTIFICATE']??'';

    $connectString = 'http://';
    if ($osHttps) {
        $connectString = 'https://';
    }
    if (!empty($osUser)) {
        $connectString .= $osUser . ':' . $osPassword . '@';
    }
    $connectString .= $osHost . ':' . $osPort;

    return \OpenSearch\ClientBuilder::create()->setHosts([$connectString])->setConnectionParams(['client' => ['curl' => [CURLOPT_TIMEOUT=>3, CURLOPT_CAINFO => $osCloudCertificate]]])->build();
}

function parseRangeFilter($field, $esField, $value) {
    $osConfig = require __DIR__.'/config.php';
    $result = [];
    $operator = '';
    if (strpos($field, '><') !== false) {
        $result[] = [
            'range'=>[
                $esField=>[
                    'gte'=>isset($osConfig['PROPERTIES'][$esField]['convert'])?$osConfig['PROPERTIES'][$esField]['convert']($value[0]):$value[0]
                ]
            ]
        ];
        $result[] = [
            'range'=>[
                $esField=>[
                    'lte'=>isset($osConfig['PROPERTIES'][$esField]['convert'])?$osConfig['PROPERTIES'][$esField]['convert']($value[1]):$value[1]
                ]
            ]
        ];
    } else if (strpos($field, '>=') !== false) {
        $operator = 'gte';
    } else if (strpos($field, '<=') !== false) {
        $operator = 'lte';
    } else if (strpos($field, '>') !== false) {
        $operator = 'gt';
    } else if (strpos($field, '<') !== false) {
        $operator = 'lt';
    }
    if (!empty($operator)) {
        $result[] = [
            'range'=>[
                $esField=>[
                    $operator=>isset($osConfig['PROPERTIES'][$esField]['convert'])?$osConfig['PROPERTIES'][$esField]['convert']($value):$value
                ]
            ]
        ];
    }
    return $result;
}

function convertBitrixFilterToOs($filter, $iblockId) {
    $osRequest = [];
    $osConfig = require __DIR__.'/config.php';
    $base_price = CCatalogGroup::GetBaseGroup();
    $propertiesIdByCode = [];
    $listPropertiesCodes = [];
    if (!empty($osConfig['PROPERTIES'])) {
        foreach ($osConfig['PROPERTIES'] as $propertyCode=>$propertyParams) {
            $res = CIBlockProperty::GetList([], ['CODE'=>$propertyCode, 'IBLOCK_ID'=>$iblockId]);
            if ($res->SelectedRowsCount() > 0) {
                $property = $res->Fetch();
                $propertiesIdByCode[$propertyCode] = (int)$property['ID'];
                if ($property['PROPERTY_TYPE'] === 'L') {
                    $listPropertiesCodes[] = $propertyCode;
                }
            }
        }
    }

    $valuesByEnumId = [];
    $res = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID'=>$iblockId, 'CODE'=>$listPropertiesCodes]);
    while ($enum = $res->Fetch()) {
        $valuesByEnumId[(int)$enum['ID']] = $enum['VALUE'];
    }

    foreach ($filter as $field=>$value) {
        foreach ($osConfig['PROPERTIES'] as $propertyCode=>$propertyParams) {
            if (strpos($field, '_'.$propertyCode) !== false || strpos($field, 'PROPERTY_'.$propertiesIdByCode[$propertyCode]) !== false) {
                if (!empty($propertyParams['filter_type'])) {
                    if ($propertyParams['filter_type'] === 'range') {
                        if (empty($osRequest['body']['query']['bool']['must'])) {
                            $osRequest['body']['query']['bool']['must'] = [];
                        }

                        $osRequest['body']['query']['bool']['must'] = array_merge($osRequest['body']['query']['bool']['must'], parseRangeFilter($field, $propertyCode, $value));
                    }
                } else {
                    if (is_array($value)) {
                        if (in_array($propertyCode, $listPropertiesCodes, true)) {
                            $newValues = [];
                            foreach ($value as $oneValue) {
                                if (isset($valuesByEnumId[$oneValue])) {
                                    $newValues[] = $valuesByEnumId[$oneValue];
                                }
                            }
                            $value = $newValues;
                        }
                        $osRequest['body']['query']['bool']['must'][]['terms'][$propertyCode] = $value;
                        if (!empty($propertyParams['convert'])) {
                            $osRequest['body']['query']['bool']['must'][]['terms'][$propertyCode] = array_map($propertyParams['convert'], $value);
                        }
                    } else {
                        if (in_array($propertyCode, $listPropertiesCodes, true) && isset($valuesByEnumId[$value])) {
                            $value = $valuesByEnumId[$value];
                        }
                        $osRequest['body']['query']['bool']['must'][]['term'][$propertyCode] = $value;
                        if (!empty($propertyParams['convert'])) {
                            $osRequest['body']['query']['bool']['must'][]['term'][$propertyCode] = $propertyParams['convert']($value);
                        }
                    }
                }
            }
        }
        if (strpos($field, 'PRICE_'.$base_price['ID']) !== false) {
            if (empty($osRequest['body']['query']['bool']['must'])) {
                $osRequest['body']['query']['bool']['must'] = [];
            }
            $osRequest['body']['query']['bool']['must'] = array_merge($osRequest['body']['query']['bool']['must'], parseRangeFilter($field, 'price', $value));
        }
    }
    return $osRequest;
}

function getSearchRequest($query) {
    $result = [
        'query' => [
            'bool' => [
                'should' => [
                    [
                        'match' => [
                            'type' => [
                                'query' => $query,
                                'operator' => 'and',
                                'boost' => 10,
                                'analyzer'=>'russian'
                            ]
                        ],
                    ],
                    [
                        'match' => [
                            'name_for_search' => [
                                'query' => $query,
                                'operator' => 'and',
                                'boost' => 2
                            ]
                        ],
                    ],
                    [
                        'match' => [
                            'name_for_search' => [
                                'query' => $query,
                                'operator' => 'or',
                                'boost' => 1.5
                            ]
                        ],
                    ],
                    [
                        'term' => [
                            'CML2_ARTICLE' => [
                                'value' => mb_strtolower($query),
                                'boost' => 1.1
                            ]
                        ]
                    ],
                    [
                        'terms' => [
                            'KF_DLYA_SAYTA_DIAMETR.key' => explode(' ', $query),
                            'boost' => 1.1,
                        ]
                    ],
                    [
                        'wildcard' => [
                            'CML2_ARTICLE' => [
                                'value'=>'*'.mb_strtolower($query) . '*'
                            ]
                        ]
                    ],
                    [
                        'match' => [
                            'KF_DLYA_SAYTA_NAIMENOVANIE' => [
                                'query' => $query,
                                'operator' => 'or',
                                'boost' => 1.1
                            ]
                        ],
                    ],
                    /*[
                        'terms' => [
                            'KF_DLYA_SAYTA_STANDART' => array_map('mb_strtolower', explode(' ', $query)),
                            'boost' => 20
                        ]
                    ],*/
                    /*[
                        'match' => [
                            'description' => [
                                'query' => $query,
                                'operator' => 'and',
                                'boost' => 8
                            ]
                        ]
                    ],*/
                    [
                        'match' => [
                            'name' => [
                                'query' => $query,
                                'operator' => 'or',
                                'boost' => 1.3
                            ]
                        ],
                    ],
                ]

            ]
        ]
    ];
    $standartTerms = array_map('mb_strtolower', explode(' ', $query));
    foreach ($standartTerms as $term) {
        $result['query']['bool']['should'][] = [
            'term' => [
                'KF_DLYA_SAYTA_STANDART'=>[
                    'value'=>$term,
                    'boost'=>0.7
                ],
            ]
        ];
    }
    return $result;
}


// function getSearchRequest($query)
// {
//     return [
//         'query' => [
//             'bool' => [
//                 'should' => [
//                     // Поиск по артикулу (точно)
//                     [
//                         'term' => [
//                             'CML2_ARTICLE' => [
//                                 'value' => mb_strtolower($query),
//                                 'boost' => 3
//                             ]
//                         ]
//                     ],

//                     // Поиск по имени — строгий
//                     [
//                         'match' => [
//                             'name' => [
//                                 'query' => $query,
//                                 'operator' => 'and',
//                                 'boost' => 2
//                             ]
//                         ]
//                     ],

//                     // Поиск по name_for_search — расширенный
//                     [
//                         'match' => [
//                             'name_for_search' => [
//                                 'query' => $query,
//                                 'operator' => 'and',
//                                 'boost' => 1.5
//                             ]
//                         ]
//                     ],
//                 ]
//             ]
//         ]
//     ];
// }


function search(string $query, int $perPage = 10, int $page = 1): array
{
    if (empty($query)) {
        return [
            'total' => 0,
            'perpage' => $perPage,
            'page' => $page,
            'items' => [],
        ];
    }

    $osConfig = require __DIR__.'/config.php';
    $os = openSearchConnect($osConfig);

    $from = $perPage * ($page - 1);

    // Основной поиск — теперь только по name
    // echo "<pre>Template arResult: "; print_r(\COption::GetOptionString('askaron.settings', 'UF_ELASTIC_INDEX')); echo "</pre>";
    $result = $os->search([
        'index' => \COption::GetOptionString('askaron.settings', 'UF_ELASTIC_INDEX'),
        'from' => $from,
        'size' => $perPage,
        'body' => getSearchRequest($query)
    ]);
//  echo "<pre>Template arResult: "; print_r($result); echo "</pre>";
    // $totalFound = (int)($result['hits']['total']['value'] ?? 0);
    $totalFound = (int)$result['hits']['total']['value'];
    // Fallback fuzzy поиск по name
    if ($totalFound === 0) {
        $result = $os->search([
            'index' => $osConfig['INDEX'],
            'from' => $from,
            'size' => $perPage,
            'body' => [
                'query' => [
                    'match' => [
                        'name' => [
                            'query' => $query,
                            'fuzziness' => 2,
                            'operator' => 'or'
                        ]
                    ]
                ]
            ]
        ]);

        // $totalFound = (int)($result['hits']['total']['value'] ?? 0);
        $totalFound = (int)$result['hits']['total']['value'];
    }

    return [
        'total' => $totalFound,
        'perpage' => $perPage,
        'page' => $page,
        'items' => $result['hits']['hits'],
    ];
}
