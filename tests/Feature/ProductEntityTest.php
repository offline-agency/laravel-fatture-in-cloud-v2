<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Product;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\Product as ProductEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductPagination;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\StockMovement;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\StockMovementList;
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

    it('handles error on list products', function () {
        Http::fake([
            'c/*/products' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Product();
        $response = $api->list();

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on all products', function () {
        Http::fake([
            'c/*/products*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Product();
        $response = $api->all();

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on product detail', function () {
        Http::fake([
            'c/*/products/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Product();
        $response = $api->detail(999);

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on delete product', function () {
        Http::fake([
            'c/*/products/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Product();
        $response = $api->delete(999);

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on create product', function () {
        Http::fake([
            'c/*/products' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Product();
        $response = $api->create([
            'data' => [
                'name' => 'Test Product',
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
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

    it('validates product edit', function () {
        $api = new Product();
        $response = $api->edit(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('handles error on edit product', function () {
        Http::fake([
            'c/*/products/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Product();
        $response = $api->edit(1, [
            'data' => [
                'name' => 'Updated',
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('lists stock movements', function () {
        $productId = 1;

        Http::fake([
            'c/*/products/'.$productId.'/stock' => Http::response([
                'data' => [
                    ['id' => 1, 'date' => '2024-06-05', 'amount' => 10.0, 'description' => 'Initial stock', 'type' => 'in'],
                ],
            ], 200),
        ]);

        $api = new Product();
        $response = $api->listStockMovements($productId);

        expect($response)->toBeInstanceOf(StockMovementList::class)
            ->getItems()->toHaveCount(1);
    });

    it('handles error on list stock movements', function () {
        Http::fake([
            'c/*/products/*/stock' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Product();
        $response = $api->listStockMovements(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('creates a stock movement', function () {
        $productId = 1;

        Http::fake([
            'c/*/products/'.$productId.'/stock' => Http::response([
                'data' => ['id' => 1, 'date' => '2024-06-05', 'amount' => 10.0, 'description' => 'New stock', 'type' => 'in'],
            ], 200),
        ]);

        $api = new Product();
        $response = $api->createStockMovement($productId, [
            'data' => [
                'date' => '2024-06-05',
                'amount' => 10.0,
                'description' => 'New stock',
            ],
        ]);

        expect($response)->toBeInstanceOf(StockMovement::class)
            ->and($response->amount)->toBe(10.0);
    });

    it('validates on create stock movement - missing data', function () {
        $api = new Product();
        $response = $api->createStockMovement(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates on create stock movement - missing data.amount', function () {
        $api = new Product();
        $response = $api->createStockMovement(1, [
            'data' => ['description' => 'Test'],
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.amount');
    });

    it('handles error on create stock movement', function () {
        Http::fake([
            'c/*/products/*/stock' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Product();
        $response = $api->createStockMovement(1, [
            'data' => ['amount' => 5.0],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('deletes a stock movement', function () {
        $productId = 1;
        $stockMovementId = 1;

        Http::fake([
            'c/*/products/'.$productId.'/stock/'.$stockMovementId => Http::response(null, 200),
        ]);

        $api = new Product();
        $response = $api->deleteStockMovement($productId, $stockMovementId);

        expect($response)->toBe('Stock movement deleted');
    });

    it('handles error on delete stock movement', function () {
        Http::fake([
            'c/*/products/*/stock/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Product();
        $response = $api->deleteStockMovement(1, 999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('edits a stock movement', function () {
        $productId = 1;
        $stockMovementId = 1;

        Http::fake([
            'c/*/products/'.$productId.'/stock/'.$stockMovementId => Http::response([
                'data' => ['id' => $stockMovementId, 'date' => '2024-06-05', 'amount' => 20.0, 'description' => 'Updated', 'type' => 'in'],
            ], 200),
        ]);

        $api = new Product();
        $response = $api->editStockMovement($productId, $stockMovementId, [
            'data' => [
                'amount' => 20.0,
                'description' => 'Updated',
            ],
        ]);

        expect($response)->toBeInstanceOf(StockMovement::class)
            ->and($response->amount)->toBe(20.0);
    });

    it('validates on edit stock movement', function () {
        $api = new Product();
        $response = $api->editStockMovement(1, 1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('handles error on edit stock movement', function () {
        Http::fake([
            'c/*/products/*/stock/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Product();
        $response = $api->editStockMovement(1, 1, [
            'data' => ['amount' => 5.0],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('checks if product list has items', function () {
        Http::fake([
            '*/products' => Http::response(
                (new ProductFakeResponse())->getProductsFakeList()
            ),
        ]);

        $api = new Product();
        $response = $api->list();

        expect($response->hasItems())->toBeTrue();
    });

    it('checks if product list is empty', function () {
        Http::fake([
            '*/products' => Http::response(
                (new ProductFakeResponse())->getEmptyProductFakeList()
            ),
        ]);

        $api = new Product();
        $response = $api->list();

        expect($response->hasItems())->toBeFalse();
    });

    it('navigates product list to next page', function () {
        $productList = new ProductList(json_decode(
            (new ProductFakeResponse())->getProductsFakeList([
                'next_page_url' => 'https://fake_url/products?per_page=10&page=2',
            ])
        ));

        Http::fake(['*/products*' => Http::response((new ProductFakeResponse())->getProductsFakeList())]);

        expect($productList->getPagination()->goToNextPage())->toBeInstanceOf(ProductList::class);
    });

    it('returns null navigating product list to next page when no next page url', function () {
        $productList = new ProductList(json_decode(
            (new ProductFakeResponse())->getProductsFakeList(['next_page_url' => null])
        ));

        expect($productList->getPagination()->goToNextPage())->toBeNull();
    });

    it('navigates product list to previous page', function () {
        $productList = new ProductList(json_decode(
            (new ProductFakeResponse())->getProductsFakeList([
                'prev_page_url' => 'https://fake_url/products?per_page=10&page=1',
            ])
        ));

        Http::fake(['*/products*' => Http::response((new ProductFakeResponse())->getProductsFakeList())]);

        expect($productList->getPagination()->goToPrevPage())->toBeInstanceOf(ProductList::class);
    });

    it('returns null navigating product list to previous page when no prev page url', function () {
        $productList = new ProductList(json_decode(
            (new ProductFakeResponse())->getProductsFakeList(['prev_page_url' => null])
        ));

        expect($productList->getPagination()->goToPrevPage())->toBeNull();
    });

    it('navigates product list to first page', function () {
        $productList = new ProductList(json_decode(
            (new ProductFakeResponse())->getProductsFakeList()
        ));

        Http::fake(['*/products*' => Http::response((new ProductFakeResponse())->getProductsFakeList())]);

        expect($productList->getPagination()->goToFirstPage())->toBeInstanceOf(ProductList::class);
    });

    it('returns null navigating product list to first page when no first page url', function () {
        $productList = new ProductList(json_decode(
            (new ProductFakeResponse())->getProductsFakeList(['first_page_url' => null])
        ));

        expect($productList->getPagination()->goToFirstPage())->toBeNull();
    });

    it('navigates product list to last page', function () {
        $productList = new ProductList(json_decode(
            (new ProductFakeResponse())->getProductsFakeList()
        ));

        Http::fake(['*/products*' => Http::response((new ProductFakeResponse())->getProductsFakeList())]);

        expect($productList->getPagination()->goToLastPage())->toBeInstanceOf(ProductList::class);
    });

    it('returns null navigating product list to last page when no last page url', function () {
        $productList = new ProductList(json_decode(
            (new ProductFakeResponse())->getProductsFakeList(['last_page_url' => null])
        ));

        expect($productList->getPagination()->goToLastPage())->toBeNull();
    });

    it('checks if stock movement list has items', function () {
        $list = new StockMovementList((object) ['data' => [
            (object) ['id' => 1, 'quantity' => 10],
        ]]);

        expect($list->hasItems())->toBeTrue();
    });

    it('checks if stock movement list is empty', function () {
        $list = new StockMovementList((object) ['data' => []]);

        expect($list->hasItems())->toBeFalse();
    });
});
