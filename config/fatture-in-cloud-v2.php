<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    */
    'baseUrl' => 'https://api-v2.fattureincloud.it/c/',

    /*
    |--------------------------------------------------------------------------
    | Companies
    |--------------------------------------------------------------------------
    |
    | By default package take the first item of this array. This means that you can change company name as you prefer.
    | You can also add more than one company and specify it on class initialization
    |
    */
    'companies' => [
        'default' => [
            'id' => env('FCV2_DEFAULT_ID', ''),
            'bearer' => env('FCV2_DEFAULT_BEARER', ''),
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Limits
    |--------------------------------------------------------------------------
    |
    | It is necessary to handle rate limiting
    | All values must be in ms
    |
    */
    'limits' => [
        'default' => 300000,
        '403' => 300000,
        '429' => 3600000
    ]
];
