<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\PriceList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\PriceList\PriceList as PriceListEntity;

describe('PriceList', function () {
    it('lists price lists', function () {
        Http::fake([
            'c/*/settings/pricelists' => Http::response([
                'data' => [
                    ['id' => 1, 'name' => 'Standard'],
                ],
            ], 200),
        ]);

        $api = new PriceList();
        $response = $api->list();

        $items = $response->getItems();

        expect($items)->toBeArray()->toHaveCount(1);
        expect($items[0]->name)->toBe('Standard');
    });

    it('handles error on list price lists', function () {
        Http::fake([
            'c/*/settings/pricelists' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new PriceList();
        $response = $api->list();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets price list detail', function () {
        Http::fake([
            'c/*/settings/pricelists/1' => Http::response([
                'data' => ['id' => 1, 'name' => 'Standard'],
            ], 200),
        ]);

        $api = new PriceList();
        $response = $api->detail(1);

        expect($response)->toBeInstanceOf(PriceListEntity::class)
            ->name->toEqual('Standard');
    });

    it('handles error on price list detail', function () {
        Http::fake([
            'c/*/settings/pricelists/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new PriceList();
        $response = $api->detail(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('deletes a price list', function () {
        $priceListId = 1;

        Http::fake([
            'c/*/settings/pricelists/'.$priceListId => Http::response(null, 200),
        ]);

        $api = new PriceList();
        $response = $api->delete($priceListId);

        expect($response)->toBe('Price list deleted');
    });

    it('handles error on delete price list', function () {
        Http::fake([
            'c/*/settings/pricelists/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new PriceList();
        $response = $api->delete(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('creates a price list', function () {
        Http::fake([
            'c/*/settings/pricelists' => Http::response([
                'data' => ['id' => 1, 'name' => 'Wholesale'],
            ], 200),
        ]);

        $api = new PriceList();
        $response = $api->create(['data' => ['name' => 'Wholesale']]);

        expect($response)->toBeInstanceOf(PriceListEntity::class)
            ->and($response->name)->toBe('Wholesale');
    });

    it('validates on create price list', function () {
        $api = new PriceList();
        $response = $api->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.name on create price list', function () {
        $api = new PriceList();
        $response = $api->create(['data' => []]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.name');
    });

    it('handles error on create price list', function () {
        Http::fake([
            'c/*/settings/pricelists' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new PriceList();
        $response = $api->create(['data' => ['name' => 'Wholesale']]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('edits a price list', function () {
        $priceListId = 1;

        Http::fake([
            'c/*/settings/pricelists/'.$priceListId => Http::response([
                'data' => ['id' => $priceListId, 'name' => 'Updated List'],
            ], 200),
        ]);

        $api = new PriceList();
        $response = $api->edit($priceListId, ['data' => ['name' => 'Updated List']]);

        expect($response)->toBeInstanceOf(PriceListEntity::class)
            ->and($response->name)->toBe('Updated List');
    });

    it('validates on edit price list', function () {
        $api = new PriceList();
        $response = $api->edit(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.name on edit price list', function () {
        $api = new PriceList();
        $response = $api->edit(1, ['data' => []]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.name');
    });

    it('handles error on edit price list', function () {
        Http::fake([
            'c/*/settings/pricelists/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new PriceList();
        $response = $api->edit(1, ['data' => ['name' => 'Updated']]);

        expect($response)->toBeInstanceOf(Error::class);
    });
});
