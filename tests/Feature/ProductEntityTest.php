<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Product;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\Product as ProductEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductPagination;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ProductFakeResponse;

describe('Product Entity', function () {
    it('lists products', function () {
        Http::fake([
            '*/products' => Http::response(
                (new ProductFakeResponse())->getProductsFakeList()
            ),
        ]);

        $api = new Product();
        $response = $api->list();

        expect($response)->toBeInstanceOf(ProductList::class)
            ->getPagination()->toBeInstanceOf(ProductPagination::class)
            ->getItems()->toBeArray()->toHaveCount(2)
            ->getItems()->{0}->toBeInstanceOf(ProductEntity::class);
    });

    it('returns all products', function () {
        Http::fake([
            '*/products' => Http::response(
                (new ProductFakeResponse())->getProductsFakeAll()
            ),
        ]);

        $api = new Product();
        $response = $api->all();

        expect($response)->toBeArray()->toHaveCount(2)
            ->{0}->toBeInstanceOf(ProductEntity::class);
    });

    it('gets product detail', function () {
        $productId = 1;

        Http::fake([
            '*/products/'.$productId => Http::response(
                (new ProductFakeResponse())->getProductsFakeDetail()
            ),
        ]);

        $api = new Product();
        $response = $api->detail($productId);

        expect($response)->toBeInstanceOf(ProductEntity::class);
    });

    it('deletes a product', function () {
        $productId = 1;

        Http::fake([
            '*/products/'.$productId => Http::response(),
        ]);

        $api = new Product();
        $response = $api->delete($productId);

        expect($response)->toBe('Product deleted');
    });

    it('creates a product', function () {
        $productName = 'New Product';

        Http::fake([
            '*/products' => Http::response(
                (new ProductFakeResponse())->getProductsFakeDetail([
                    'name' => $productName,
                ])
            ),
        ]);

        $api = new Product();
        $response = $api->create([
            'data' => [
                'name' => $productName,
                'code' => 'p001',
                'description' => 'Desc',
            ],
        ]);

        expect($response)->toBeInstanceOf(ProductEntity::class)
            ->name->toBe($productName);
    });

    it('validates product creation', function () {
        $api = new Product();
        $response = $api->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('edits a product', function () {
        $productId = 1;
        $newName = 'Updated Name';

        Http::fake([
            '*/products/'.$productId => Http::response(
                (new ProductFakeResponse())->getProductsFakeDetail([
                    'id' => $productId,
                    'name' => $newName,
                ])
            ),
        ]);

        $api = new Product();
        $response = $api->edit($productId, [
            'data' => [
                'name' => $newName,
            ],
        ]);

        expect($response)->toBeInstanceOf(ProductEntity::class)
            ->name->toBe($newName);
    });
});
