<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Taxes;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\Taxes as TaxesEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\TaxesList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\TaxesPagination;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\TaxesFakeResponse;

describe('Taxes Entity', function () {
    it('lists taxes', function () {
        $type = 'invoice';

        Http::fake([
            '*/taxes?type='.$type => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeList()
            ),
        ]);

        $api = new Taxes();
        $response = $api->list($type);

        expect($response)->toBeInstanceOf(TaxesList::class)
            ->getPagination()->toBeInstanceOf(TaxesPagination::class)
            ->getItems()->toBeArray()->toHaveCount(2)
            ->getItems()->{0}->toBeInstanceOf(TaxesEntity::class);
    });

    it('returns all taxes', function () {
        $type = 'expense';

        Http::fake([
            '*/taxes?type='.$type => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeAll()
            ),
        ]);

        $api = new Taxes();
        $response = $api->all($type);

        expect($response)->toBeArray()->toHaveCount(2)
            ->{0}->toBeInstanceOf(TaxesEntity::class);
    });

    it('gets tax detail', function () {
        $documentId = 1;

        Http::fake([
            '*/taxes/'.$documentId => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeDetail()
            ),
        ]);

        $api = new Taxes();
        $response = $api->detail($documentId);

        expect($response)->toBeInstanceOf(TaxesEntity::class);
    });

    it('deletes a tax entry', function () {
        $documentId = 1;

        Http::fake([
            '*/taxes/'.$documentId => Http::response(),
        ]);

        $api = new Taxes();
        $response = $api->delete($documentId);

        expect($response)->toBe('Taxes deleted');
    });

    it('creates a tax entry', function () {
        $entityName = 'Test S.R.L';

        Http::fake([
            '*/taxes' => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeDetail([
                    'entity' => [
                        'name' => $entityName,
                    ],
                ])
            ),
        ]);

        $api = new Taxes();
        $response = $api->create([
            'data' => [
                'type' => 'expense',
                'entity' => [
                    'name' => $entityName,
                ],
                'date' => '2024-01-01',
            ],
        ]);

        expect($response)->toBeInstanceOf(TaxesEntity::class);
    });

    it('validates tax creation', function () {
        $api = new Taxes();
        $response = $api->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('deletes a tax attachment', function () {
        $documentId = 1;

        Http::fake([
            '*/taxes/'.$documentId.'/attachment' => Http::response(),
        ]);

        $api = new Taxes();
        $response = $api->deleteAttachment($documentId);

        expect($response)->toBe('Attachment deleted');
    });
});
