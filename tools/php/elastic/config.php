<?php
return [
    //Opensearch Params
    'USER'=>\COption::GetOptionString('askaron.settings', 'UF_OS_USER'),
    'PASSWORD'=>\COption::GetOptionString('askaron.settings', 'UF_OS_PASSWORD'),
    'HOST'=>\COption::GetOptionString('askaron.settings', 'UF_OS_HOST'),
    'PORT'=>\COption::GetOptionString('askaron.settings', 'UF_OS_PORT'),
    'HTTPS'=>\COption::GetOptionString('askaron.settings', 'UF_OS_HTTPS') > 0,
    'CLOUD_CERTIFICATE'=>\COption::GetOptionString('askaron.settings', 'UF_CLOUD_CERTIFICATE'),
    'INDEX'=>\COption::GetOptionString('askaron.settings', 'UF_OS_PRODUCT_INDEX'),

    //catalog params
    'CATALOG_IBLOCK_ID'=>10,
    'PROPERTIES'=>[
        'CML2_ARTICLE'=>[
            'elastic_type'=>'keyword',
            'convert'=> static function ($value) {
                return mb_strtolower($value);
            },
            'export_convert'=> static function ($value) {
                return mb_strtolower($value);
            }
        ],
        'KF_DLYA_SAYTA_NAIMENOVANIE'=>[],
        'KF_DLYA_SAYTA_DIAMETR'=>[
            'elastic_type'=>'float',
            'filter_type'=>'range',
            'convert'=> static function ($value) {
                return str_replace([',', ' ', ' '], ['.', '', ''], $value);
            },
            'export_convert'=> static function ($value) {
                return str_replace([',', ' ', ' '], ['.', '', ''], $value);
            }
        ],
        'KF_DLYA_SAYTA_DLINA'=>[
            'elastic_type'=>'float',
            'filter_type'=>'range',
            'convert'=>static function ($value) {
                return str_replace([',', ' ', ' '], ['.', '', ''], $value);
            },
            'export_convert'=>static function ($value) {
                return str_replace([',', ' ', ' '], ['.', '', ''], $value);
            }
        ],
        'KF_DLYA_SAYTA_STANDART'=>[
            'elastic_type'=>'keyword',
            'export_convert'=>static function ($originalValue) {
                $value = mb_strtolower($originalValue);
                $rus = str_replace('din', 'дин', $value);
                $result = [$originalValue, str_replace(' ', '', $value), str_replace(' ', '', $rus)];
                $parts = explode(' ', $value);
                if (!empty($parts[1])) {
                    $result[] = $parts[1];
                }
                if (!empty($parts[0])) {
                    $result[] = $parts[0];
                    if ($parts[0] === 'din') {
                        $result[] = 'дин';
                    }
                }
                return $result;
                //return [$value, str_replace(' ', '', $value), $rus, str_replace(' ', '', $rus)];
            }
        ],
        'KF_DLYA_SAYTA_MATERIAL'=>[],
        'KF_DLYA_SAYTA_SHLITS'=>[],
        'KF_DLYA_SAYTA_KONETS_REZBY'=>[],
        'KF_DLYA_SAYTA_NAKONECHNIK'=>[],
        'KF_DLYA_SAYTA_DLINA_RABOCHAYA'=>[],
        'KF_DLYA_SAYTA_POSADOCHNYY_DIAMETR'=>[],
        'KF_DLYA_SAYTA_TOLSHCHINA'=>[
            'elastic_type'=>'float',
            'convert'=>static function ($value) {
                return str_replace([',', ' ', ' '], ['.', '', ''], $value);
            },
            'export_convert'=>static function ($value) {
                return str_replace([',', ' ', ' '], ['.', '', ''], $value);
            }
        ],
        'KF_DLYA_SAYTA_AKTUALNOST'=>[],
        'KF_DLYA_SAYTA_ZERNO'=>[],
        'NEW'=>[],
        'KHIT'=>[],
        'KF_DLYA_SAYTA_SHAG_REZBY'=>[],
        'KF_DLYA_SAYTA_STRANA_PROIZVODSTVA'=>[],
        'KF_DLYA_SAYTA_UPAKOVKA'=>[]
    ]
];
