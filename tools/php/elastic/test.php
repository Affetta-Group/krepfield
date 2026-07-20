<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$config = require __DIR__.'/config.php';
require_once __DIR__.'/functions.php';

$os = openSearchConnect($config);


print_r($os->cat()->indices());
die();

$doc = $os->get([
    'index'=>$config['INDEX'],
    'id'=>8993
]);
print_r($doc);
//$query = '933а2болт6';
$query = '933А2БОЛТ6Х10-20';

print_r(getSearchRequest($query));

$searchQuery = [
    'query' => [
        'bool' => [
            'should' => [
                [
                    'wildcard' => [
                        'CML2_ARTICLE' => [
                            'value'=>'*'.$query . '*'
                        ]
                    ]
                ],

            ]

        ]
    ]
];

$result = $os->explain([
    'index'=>$config['INDEX'],
    'id'=>8993,
    'body'=>getSearchRequest($query)
    //'body'=>$searchQuery

]);
print_r($result);