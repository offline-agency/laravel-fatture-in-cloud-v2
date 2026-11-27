<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    */
    'baseUrl' => 'https://api-v2.fattureincloud.it/',

    /*
    |--------------------------------------------------------------------------
    | Company
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
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Limits
    |--------------------------------------------------------------------------
    |
    | Only HTTP 429 (short-term rate limit: 300 requests / 5 minutes per
    | company) is retried. HTTP 403 is never retried: Fatture in Cloud uses it
    | for missing scopes, expired licenses and exhausted hourly/monthly quotas.
    |
    | The wait comes from the Retry-After header when present, otherwise from
    | an exponential backoff starting at `retry_delay`. If the required wait is
    | longer than `max_wait`, the request fails immediately instead of
    | blocking your web request or queue worker.
    |
    | All durations are in milliseconds.
    |
    | https://developers.fattureincloud.it/docs/basics/limits-and-quotas/
    |
    */
    'limits' => [
        'max_retries' => 3,      // total attempts, including the first one
        'retry_delay' => 1000,   // ms, doubled on each attempt
        'max_wait' => 60000,     // ms, longest single wait allowed
    ],
];
