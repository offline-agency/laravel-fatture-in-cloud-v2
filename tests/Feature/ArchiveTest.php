<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Archive;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Archive\Archive as ArchiveEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Archive\ArchiveList;

it('lists archive documents', function () {
    Http::fake([
        'c/*/archive*' => Http::response([
            'data' => [
                ['id' => 1, 'description' => 'Doc'],
            ],
        ], 200),
    ]);

    $api = new Archive();
    $response = $api->list();

    expect($response)->toBeInstanceOf(ArchiveList::class)
        ->getItems()->toHaveCount(1);
});

it('creates an archive document', function () {
    $data = ['data' => ['description' => 'Doc', 'date' => '2024-06-06', 'category' => 'category']];

    Http::fake([
        'c/*/archive' => Http::response([
            'data' => ['id' => 1, 'description' => 'Doc', 'category' => 'category'],
        ], 200),
    ]);

    $api = new Archive();
    $response = $api->create($data);

    expect($response)->toBeInstanceOf(ArchiveEntity::class);
    expect($response->description)->toEqual('Doc');
    expect($response->category)->toEqual('category');
});
