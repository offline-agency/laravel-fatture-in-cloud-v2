<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Cashbook;
use OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook\CashbookEntry;
use OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook\CashbookList;

it('creates a cash book entry', function () {
    $data = [
        'data' => [
            'date' => '2024-06-05',
            'description' => 'A description',
            'kind' => 'cashbook',
            'amount_in' => 100.00,
        ],
    ];

    Http::fake([
        'c/*/cashbook' => Http::response([
            'data' => [
                'id' => 1,
                'date' => '2024-06-05',
                'description' => 'A description',
                'kind' => 'cashbook',
                'amount_in' => 100.00,
            ],
        ], 200),
    ]);

    $cashbookApi = new Cashbook();
    $response = $cashbookApi->create($data);

    expect($response)->toBeInstanceOf(CashbookEntry::class)
        ->id->toBe(1)
        ->date->toBe('2024-06-05');
});

it('lists cashbook entries', function () {
    Http::fake([
        'c/*/cashbook*' => Http::response([
            'data' => [
                [
                    'id' => 1,
                    'date' => '2024-06-05',
                    'description' => 'A description',
                    'kind' => 'cashbook',
                    'amount_in' => 100.00,
                ],
            ],
            'current_page' => 1,
            'first_page_url' => 'https://example.com/page=1',
            'from' => 1,
            'last_page' => 1,
            'last_page_url' => 'https://example.com/page=1',
            'next_page_url' => null,
            'path' => 'https://example.com',
            'per_page' => 5,
            'prev_page_url' => null,
            'to' => 1,
            'total' => 1,
        ], 200),
    ]);

    $cashbookApi = new Cashbook();
    $response = $cashbookApi->list();

    expect($response)->toBeInstanceOf(CashbookList::class)
        ->getItems()->toHaveCount(1);
});
