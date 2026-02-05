<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\PriceList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\PriceList\PriceList as PriceListEntity;

it('lists price lists', function () {
    $priceListApi = new PriceList();

    Http::fake([
        'c/*/settings/pricelists' => Http::response([
            'data' => [
                ['id' => 1, 'name' => 'Standard'],
            ],
        ], 200),
    ]);

    $response = $priceListApi->list();

    $items = $response->getItems();

    expect($items)->toBeArray()->toHaveCount(1);
    expect($items[0]->name)->toBe('Standard');
});

it('gets price list detail', function () {
    $priceListApi = new PriceList();

    Http::fake([
        'c/*/settings/pricelists/1' => Http::response([
            'data' => ['id' => 1, 'name' => 'Standard'],
        ], 200),
    ]);

    $response = $priceListApi->detail(1);

    expect($response)->toBeInstanceOf(PriceListEntity::class)
        ->name->toEqual('Standard');
});
