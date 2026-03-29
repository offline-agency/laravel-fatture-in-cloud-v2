<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Supplier;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier\Supplier as SupplierEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier\SupplierList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier\SupplierPagination;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\SupplierFakeResponse;

describe('Supplier Entity', function () {
    it('lists suppliers', function () {
        Http::fake([
            '*/entities/suppliers' => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeList()
            ),
        ]);

        $api = new Supplier();
        $response = $api->list();

        expect($response)->toBeInstanceOf(SupplierList::class)
            ->getPagination()->toBeInstanceOf(SupplierPagination::class)
            ->getItems()->toBeArray()->toHaveCount(2)
            ->getItems()->{0}->toBeInstanceOf(SupplierEntity::class);
    });

    it('returns all suppliers', function () {
        Http::fake([
            '*/entities/suppliers' => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeAll()
            ),
        ]);

        $api = new Supplier();
        $response = $api->all();

        expect($response)->toBeArray()->toHaveCount(2)
            ->{0}->toBeInstanceOf(SupplierEntity::class);
    });

    it('gets supplier detail', function () {
        $supplierId = 1;

        Http::fake([
            '*/entities/suppliers/'.$supplierId => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeDetail()
            ),
        ]);

        $api = new Supplier();
        $response = $api->detail($supplierId);

        expect($response)->toBeInstanceOf(SupplierEntity::class);
    });

    it('deletes a supplier', function () {
        $supplierId = 1;

        Http::fake([
            '*/entities/suppliers/'.$supplierId => Http::response(),
        ]);

        $api = new Supplier();
        $response = $api->delete($supplierId);

        expect($response)->toBe('Supplier deleted');
    });

    it('creates a supplier', function () {
        $supplierName = 'Test Supplier';

        Http::fake([
            '*/entities/suppliers' => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeDetail([
                    'name' => $supplierName,
                ])
            ),
        ]);

        $api = new Supplier();
        $response = $api->create([
            'data' => [
                'name' => $supplierName,
            ],
        ]);

        expect($response)->toBeInstanceOf(SupplierEntity::class)
            ->name->toBe($supplierName);
    });

    it('validates supplier creation', function () {
        $api = new Supplier();
        $response = $api->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('edits a supplier', function () {
        $supplierId = 1;
        $newName = 'Updated Name';

        Http::fake([
            '*/entities/suppliers/'.$supplierId => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeDetail([
                    'name' => $newName,
                ])
            ),
        ]);

        $api = new Supplier();
        $response = $api->edit($supplierId, [
            'data' => [
                'name' => $newName,
            ],
        ]);

        expect($response)->toBeInstanceOf(SupplierEntity::class)
            ->name->toBe($newName);
    });

    it('handles error on list suppliers', function () {
        Http::fake([
            'c/*/entities/suppliers' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Supplier();
        $response = $api->list();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('handles error on all suppliers', function () {
        Http::fake([
            'c/*/entities/suppliers' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Supplier();
        $response = $api->all();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('handles error on supplier detail', function () {
        Http::fake([
            'c/*/entities/suppliers/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Supplier();
        $response = $api->detail(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('handles error on delete supplier', function () {
        Http::fake([
            'c/*/entities/suppliers/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Supplier();
        $response = $api->delete(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('validates data.name on supplier creation', function () {
        $api = new Supplier();
        $response = $api->create(['data' => []]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.name');
    });

    it('handles error on create supplier', function () {
        Http::fake([
            'c/*/entities/suppliers' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Supplier();
        $response = $api->create([
            'data' => ['name' => 'Test Supplier'],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('validates supplier edit - missing data', function () {
        $api = new Supplier();
        $response = $api->edit(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.name on supplier edit', function () {
        $api = new Supplier();
        $response = $api->edit(1, ['data' => []]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.name');
    });

    it('handles error on edit supplier', function () {
        Http::fake([
            'c/*/entities/suppliers/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Supplier();
        $response = $api->edit(1, [
            'data' => ['name' => 'Test Supplier'],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('checks if supplier list has items', function () {
        Http::fake([
            '*/entities/suppliers' => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeList()
            ),
        ]);

        $api = new Supplier();
        $response = $api->list();

        expect($response->hasItems())->toBeTrue();
    });

    it('checks if supplier list is empty', function () {
        Http::fake([
            '*/entities/suppliers' => Http::response(json_encode(['data' => []])),
        ]);

        $api = new Supplier();
        $response = $api->list();

        expect($response->hasItems())->toBeFalse();
    });

    it('navigates supplier list to next page', function () {
        $supplierList = new SupplierList(json_decode(
            (new SupplierFakeResponse())->getSupplierFakeList([
                'next_page_url' => 'https://fake_url/entities/suppliers?per_page=10&page=2',
            ])
        ));

        Http::fake(['c/*/entities/suppliers*' => Http::response((new SupplierFakeResponse())->getSupplierFakeList())]);

        expect($supplierList->getPagination()->goToNextPage())->toBeInstanceOf(SupplierList::class);
    });

    it('returns null navigating supplier list to next page when no next page url', function () {
        $supplierList = new SupplierList(json_decode(
            (new SupplierFakeResponse())->getSupplierFakeList(['next_page_url' => null])
        ));

        expect($supplierList->getPagination()->goToNextPage())->toBeNull();
    });

    it('navigates supplier list to previous page', function () {
        $supplierList = new SupplierList(json_decode(
            (new SupplierFakeResponse())->getSupplierFakeList([
                'prev_page_url' => 'https://fake_url/entities/suppliers?per_page=10&page=1',
            ])
        ));

        Http::fake(['c/*/entities/suppliers*' => Http::response((new SupplierFakeResponse())->getSupplierFakeList())]);

        expect($supplierList->getPagination()->goToPrevPage())->toBeInstanceOf(SupplierList::class);
    });

    it('returns null navigating supplier list to previous page when no prev page url', function () {
        $supplierList = new SupplierList(json_decode(
            (new SupplierFakeResponse())->getSupplierFakeList(['prev_page_url' => null])
        ));

        expect($supplierList->getPagination()->goToPrevPage())->toBeNull();
    });

    it('navigates supplier list to first page', function () {
        $supplierList = new SupplierList(json_decode(
            (new SupplierFakeResponse())->getSupplierFakeList()
        ));

        Http::fake(['c/*/entities/suppliers*' => Http::response((new SupplierFakeResponse())->getSupplierFakeList())]);

        expect($supplierList->getPagination()->goToFirstPage())->toBeInstanceOf(SupplierList::class);
    });

    it('returns null navigating supplier list to first page when no first page url', function () {
        $supplierList = new SupplierList(json_decode(
            (new SupplierFakeResponse())->getSupplierFakeList(['first_page_url' => null])
        ));

        expect($supplierList->getPagination()->goToFirstPage())->toBeNull();
    });

    it('navigates supplier list to last page', function () {
        $supplierList = new SupplierList(json_decode(
            (new SupplierFakeResponse())->getSupplierFakeList()
        ));

        Http::fake(['c/*/entities/suppliers*' => Http::response((new SupplierFakeResponse())->getSupplierFakeList())]);

        expect($supplierList->getPagination()->goToLastPage())->toBeInstanceOf(SupplierList::class);
    });

    it('returns null navigating supplier list to last page when no last page url', function () {
        $supplierList = new SupplierList(json_decode(
            (new SupplierFakeResponse())->getSupplierFakeList(['last_page_url' => null])
        ));

        expect($supplierList->getPagination()->goToLastPage())->toBeNull();
    });

    it('handles null constructor parameter', function () {
        $entity = new SupplierEntity(null);

        expect($entity->id)->toBeNull()
            ->and($entity->name)->toBeNull();
    });
})->covers(Supplier::class);
