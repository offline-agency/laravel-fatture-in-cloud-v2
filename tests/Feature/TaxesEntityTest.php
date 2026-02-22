<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Taxes;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\Taxes as TaxesEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\TaxesAttachment;
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

    it('handles error on list taxes', function () {
        Http::fake([
            'c/*/taxes*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Taxes();
        $response = $api->list('expense');

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on all taxes', function () {
        Http::fake([
            'c/*/taxes*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Taxes();
        $response = $api->all('expense');

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on tax detail', function () {
        Http::fake([
            'c/*/taxes/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Taxes();
        $response = $api->detail(999);

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on delete tax entry', function () {
        Http::fake([
            'c/*/taxes/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Taxes();
        $response = $api->delete(999);

        expect($response)->toBeInstanceOf(Error::class);
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

    it('validates data.type on create tax entry', function () {
        $api = new Taxes();
        $response = $api->create([
            'data' => [
                'type' => 'invalid_type',
                'entity' => ['name' => 'Test S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.type');
    });

    it('validates data.entity.name on create tax entry', function () {
        $api = new Taxes();
        $response = $api->create([
            'data' => [
                'type' => 'expense',
            ],
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.entity.name');
    });

    it('handles error on create tax entry', function () {
        Http::fake([
            'c/*/taxes' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Taxes();
        $response = $api->create([
            'data' => [
                'type' => 'expense',
                'entity' => ['name' => 'Test S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('edits a tax entry', function () {
        $documentId = 1;

        Http::fake([
            'c/*/taxes/'.$documentId => Http::response([
                'data' => [
                    'id' => $documentId,
                    'type' => 'expense',
                    'entity' => ['name' => 'Updated S.R.L'],
                ],
            ], 200),
        ]);

        $api = new Taxes();
        $response = $api->edit($documentId, [
            'data' => [
                'entity' => ['name' => 'Updated S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(TaxesEntity::class);
    });

    it('validates on edit tax entry - missing data', function () {
        $api = new Taxes();
        $response = $api->edit(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.entity.name on edit tax entry', function () {
        $api = new Taxes();
        $response = $api->edit(1, [
            'data' => [
                'type' => 'expense',
            ],
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.entity.name');
    });

    it('handles error on edit tax entry', function () {
        Http::fake([
            'c/*/taxes/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Taxes();
        $response = $api->edit(1, [
            'data' => [
                'entity' => ['name' => 'Test S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets tax bin entry', function () {
        $documentId = 1;

        Http::fake([
            'c/*/bin/taxes/'.$documentId => Http::response([
                'data' => [
                    'id' => $documentId,
                    'type' => 'expense',
                    'entity' => ['name' => 'Test S.R.L'],
                ],
            ], 200),
        ]);

        $api = new Taxes();
        $response = $api->bin($documentId);

        expect($response)->toBeInstanceOf(TaxesEntity::class)
            ->and($response->id)->toBe($documentId);
    });

    it('handles error on tax bin entry', function () {
        Http::fake([
            'c/*/bin/taxes/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Taxes();
        $response = $api->bin(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('handles binDetail when document is found directly', function () {
        $documentId = 1;

        Http::fake([
            'c/*/taxes/'.$documentId => Http::response([
                'data' => ['id' => $documentId, 'type' => 'expense', 'entity' => ['name' => 'Test S.R.L']],
            ], 200),
        ]);

        $api = new Taxes();
        $response = $api->binDetail($documentId);

        expect($response)->toBeInstanceOf(TaxesEntity::class);
    });

    it('handles binDetail falling back to bin', function () {
        $documentId = 1;

        Http::fake([
            'c/*/bin/taxes/'.$documentId => Http::response([
                'data' => ['id' => $documentId, 'type' => 'expense', 'entity' => ['name' => 'Test S.R.L']],
            ], 200),
            'c/*/taxes/'.$documentId => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Taxes();
        $response = $api->binDetail($documentId);

        expect($response)->toBeInstanceOf(TaxesEntity::class);
    });

    it('handles binDetail when both detail and bin fail', function () {
        Http::fake([
            'c/*/taxes/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
            'c/*/bin/taxes/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Taxes();
        $response = $api->binDetail(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('uploads a tax attachment', function () {
        Http::fake([
            'c/*/taxes/attachment' => Http::response([
                'data' => ['attachment_token' => 'tok_abc123'],
            ], 200),
        ]);

        $api = new Taxes();
        $response = $api->attachment([
            'filename' => 'test.pdf',
            'attachment' => 'file_content',
        ]);

        expect($response)->toBeInstanceOf(TaxesAttachment::class)
            ->and($response->attachment_token)->toBe('tok_abc123');
    });

    it('validates filename on tax attachment upload', function () {
        $api = new Taxes();
        $response = $api->attachment([
            'attachment' => 'file_content',
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('filename');
    });

    it('validates attachment on tax attachment upload', function () {
        $api = new Taxes();
        $response = $api->attachment([
            'filename' => 'test.pdf',
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('attachment');
    });

    it('handles error on tax attachment upload', function () {
        Http::fake([
            'c/*/taxes/attachment' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Taxes();
        $response = $api->attachment([
            'filename' => 'test.pdf',
            'attachment' => 'file_content',
        ]);

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on delete tax attachment', function () {
        Http::fake([
            'c/*/taxes/*/attachment' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Taxes();
        $response = $api->deleteAttachment(999);

        expect($response)->toBeInstanceOf(Error::class);
    });
});
