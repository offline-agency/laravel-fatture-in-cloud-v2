<?php

return [
    'baseUrl' => 'https://api-v2.fattureincloud.it/c/',

    'companies' => [
        'default' => [
            'id'     => env('FCV2_DEFAULT_ID', ''),
            'bearer' => env('FCV2_DEFAULT_BEARER', ''),
        ],
        'test' => [
            'id'     => env('FCV2_DEFAULT_ID', 'test_id'),
            'bearer' => env('FCV2_DEFAULT_BEARER', 'test_bearer'),
        ],
    ],
];
