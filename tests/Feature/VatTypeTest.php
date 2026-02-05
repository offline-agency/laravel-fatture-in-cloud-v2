<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\VatType;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\VatType as VatTypeEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\VatTypeList;

it('lists vat types', function () {
    Http::fake([
        'c/*/settings/vat_types' => Http::response([
            'data' => [
                ['id' => 1, 'value' => 22],
            ],
        ], 200),
    ]);

    $api = new VatType();
    $response = $api->list();

    expect($response)->toBeInstanceOf(VatTypeList::class)
        ->getItems()->toHaveCount(1);
});

it('creates a vat type', function () {
    $data = ['data' => ['value' => 22]];

    Http::fake([
        'c/*/settings/vat_types' => Http::response([
            'data' => ['id' => 1, 'value' => 22],
        ], 200),
    ]);

    $api = new VatType();
    $response = $api->create($data);

    expect($response)->toBeInstanceOf(VatTypeEntity::class);
    expect($response->value)->toEqual(22);
});
