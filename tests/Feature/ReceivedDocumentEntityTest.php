<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\ReceivedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocument as ReceivedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentAttachment;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentPagination;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentPreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentTotals;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocumentFakeResponse;

describe('Received Document Entity', function () {
    it('lists received documents', function () {
        $type = 'expense';

        Http::fake([
            '*/received_documents?type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentsFakeList()
            ),
        ]);

        $api = new ReceivedDocument();
        $response = $api->list($type);

        expect($response)->toBeInstanceOf(ReceivedDocumentList::class)
            ->getPagination()->toBeInstanceOf(ReceivedDocumentPagination::class)
            ->getItems()->toBeArray()->toHaveCount(2)
            ->getItems()->{0}->toBeInstanceOf(ReceivedDocumentEntity::class);
    });

    it('handles error on list received documents', function () {
        Http::fake([
            'c/*/received_documents*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new ReceivedDocument();
        $response = $api->list('expense');

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('returns all received documents', function () {
        $type = 'expense';

        Http::fake([
            '*/received_documents?type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentsFakeAll()
            ),
        ]);

        $api = new ReceivedDocument();
        $response = $api->all($type);

        expect($response)->toBeArray()->toHaveCount(2)
            ->{0}->toBeInstanceOf(ReceivedDocumentEntity::class);
    });

    it('handles error on all received documents', function () {
        Http::fake([
            'c/*/received_documents*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new ReceivedDocument();
        $response = $api->all('expense');

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets document detail', function () {
        $documentId = 1;

        Http::fake([
            '*/received_documents/'.$documentId => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeDetail()
            ),
        ]);

        $api = new ReceivedDocument();
        $response = $api->detail($documentId);

        expect($response)->toBeInstanceOf(ReceivedDocumentEntity::class);
    });

    it('handles error on document detail', function () {
        Http::fake([
            'c/*/received_documents/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new ReceivedDocument();
        $response = $api->detail(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('deletes a document', function () {
        $documentId = 1;

        Http::fake([
            '*/received_documents/'.$documentId => Http::response(),
        ]);

        $api = new ReceivedDocument();
        $response = $api->delete($documentId);

        expect($response)->toBe('Document deleted');
    });

    it('handles error on delete document', function () {
        Http::fake([
            'c/*/received_documents/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new ReceivedDocument();
        $response = $api->delete(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('creates a document', function () {
        $entityName = 'Test S.R.L';

        Http::fake([
            '*/received_documents' => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeDetail([
                    'entity' => [
                        'name' => $entityName,
                    ],
                ])
            ),
        ]);

        $api = new ReceivedDocument();
        $response = $api->create([
            'data' => [
                'type' => 'expense',
                'entity' => [
                    'name' => $entityName,
                ],
            ],
        ]);

        expect($response)->toBeInstanceOf(ReceivedDocumentEntity::class);
    });

    it('validates document creation', function () {
        $api = new ReceivedDocument();
        $response = $api->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('handles error on create document', function () {
        Http::fake([
            'c/*/received_documents' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new ReceivedDocument();
        $response = $api->create([
            'data' => [
                'type' => 'expense',
                'entity' => ['name' => 'Test S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('edits a document', function () {
        $documentId = 1;

        Http::fake([
            'c/*/received_documents/'.$documentId => Http::response([
                'data' => [
                    'id' => $documentId,
                    'type' => 'expense',
                    'entity' => ['name' => 'Updated S.R.L'],
                ],
            ], 200),
        ]);

        $api = new ReceivedDocument();
        $response = $api->edit($documentId, [
            'data' => [
                'entity' => ['name' => 'Updated S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(ReceivedDocumentEntity::class);
    });

    it('validates on edit document - missing data', function () {
        $api = new ReceivedDocument();
        $response = $api->edit(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.entity.name on edit document', function () {
        $api = new ReceivedDocument();
        $response = $api->edit(1, [
            'data' => ['type' => 'expense'],
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.entity.name');
    });

    it('handles error on edit document', function () {
        Http::fake([
            'c/*/received_documents/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new ReceivedDocument();
        $response = $api->edit(1, [
            'data' => ['entity' => ['name' => 'Test S.R.L']],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets new totals', function () {
        Http::fake([
            'c/*/received_documents/totals' => Http::response([
                'data' => [
                    'amount_net' => 100.0,
                    'amount_vat' => 22.0,
                    'amount_gross' => 122.0,
                ],
            ], 200),
        ]);

        $api = new ReceivedDocument();
        $response = $api->getNewTotals([
            'data' => [
                'type' => 'expense',
                'entity' => ['name' => 'Test S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(ReceivedDocumentTotals::class);
    });

    it('validates on get new totals - missing data', function () {
        $api = new ReceivedDocument();
        $response = $api->getNewTotals([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.entity.name on get new totals', function () {
        $api = new ReceivedDocument();
        $response = $api->getNewTotals([
            'data' => ['type' => 'expense'],
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.entity.name');
    });

    it('handles error on get new totals', function () {
        Http::fake([
            'c/*/received_documents/totals' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new ReceivedDocument();
        $response = $api->getNewTotals([
            'data' => [
                'type' => 'expense',
                'entity' => ['name' => 'Test S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets existing totals', function () {
        $documentId = 1;

        Http::fake([
            'c/*/received_documents/'.$documentId.'/totals' => Http::response([
                'data' => [
                    'amount_net' => 100.0,
                    'amount_vat' => 22.0,
                    'amount_gross' => 122.0,
                ],
            ], 200),
        ]);

        $api = new ReceivedDocument();
        $response = $api->getExistingTotals($documentId, [
            'data' => [
                'entity' => ['name' => 'Test S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(ReceivedDocumentTotals::class);
    });

    it('validates on get existing totals - missing data', function () {
        $api = new ReceivedDocument();
        $response = $api->getExistingTotals(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('handles error on get existing totals', function () {
        Http::fake([
            'c/*/received_documents/*/totals' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new ReceivedDocument();
        $response = $api->getExistingTotals(1, [
            'data' => ['entity' => ['name' => 'Test S.R.L']],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets pre-create info', function () {
        $type = 'expense';

        Http::fake([
            '*/received_documents/info?type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakePreCreateInfo()
            ),
        ]);

        $api = new ReceivedDocument();
        $response = $api->preCreateInfo($type);

        expect($response)->toBeInstanceOf(ReceivedDocumentPreCreateInfo::class);
    });

    it('handles error on pre-create info', function () {
        Http::fake([
            'c/*/received_documents/info*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new ReceivedDocument();
        $response = $api->preCreateInfo('expense');

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('uploads an attachment', function () {
        Http::fake([
            'c/*/received_documents/attachment' => Http::response([
                'data' => ['attachment_token' => 'tok_abc123'],
            ], 200),
        ]);

        $api = new ReceivedDocument();
        $response = $api->attachment([
            'filename' => 'test.pdf',
            'attachment' => 'file_content',
        ]);

        expect($response)->toBeInstanceOf(ReceivedDocumentAttachment::class)
            ->and($response->attachment_token)->toBe('tok_abc123');
    });

    it('validates filename on attachment upload', function () {
        $api = new ReceivedDocument();
        $response = $api->attachment([
            'attachment' => 'file_content',
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('filename');
    });

    it('validates attachment on attachment upload', function () {
        $api = new ReceivedDocument();
        $response = $api->attachment([
            'filename' => 'test.pdf',
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('attachment');
    });

    it('handles error on attachment upload', function () {
        Http::fake([
            'c/*/received_documents/attachment' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new ReceivedDocument();
        $response = $api->attachment([
            'filename' => 'test.pdf',
            'attachment' => 'file_content',
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('deletes an attachment', function () {
        $documentId = 1;

        Http::fake([
            '*/received_documents/'.$documentId.'/attachment' => Http::response(),
        ]);

        $api = new ReceivedDocument();
        $response = $api->deleteAttachment($documentId);

        expect($response)->toBe('Attachment deleted');
    });

    it('handles error on delete attachment', function () {
        Http::fake([
            'c/*/received_documents/*/attachment' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new ReceivedDocument();
        $response = $api->deleteAttachment(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('handles binDetail when document is found directly', function () {
        $documentId = 1;

        Http::fake([
            'c/*/received_documents/'.$documentId => Http::response([
                'data' => ['id' => $documentId, 'type' => 'expense', 'entity' => ['name' => 'Test S.R.L']],
            ], 200),
        ]);

        $api = new ReceivedDocument();
        $response = $api->binDetail($documentId);

        expect($response)->toBeInstanceOf(ReceivedDocumentEntity::class);
    });

    it('handles binDetail falling back to bin', function () {
        $documentId = 1;

        Http::fake([
            'c/*/bin/received_documents/'.$documentId => Http::response([
                'data' => ['id' => $documentId, 'type' => 'expense', 'entity' => ['name' => 'Test S.R.L']],
            ], 200),
            'c/*/received_documents/'.$documentId => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new ReceivedDocument();
        $response = $api->binDetail($documentId);

        expect($response)->toBeInstanceOf(ReceivedDocumentEntity::class);
    });

    it('handles binDetail when both detail and bin fail', function () {
        Http::fake([
            'c/*/received_documents/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
            'c/*/bin/received_documents/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new ReceivedDocument();
        $response = $api->binDetail(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets bin document', function () {
        $documentId = 1;

        Http::fake([
            'c/*/bin/received_documents/'.$documentId => Http::response([
                'data' => ['id' => $documentId, 'type' => 'expense', 'entity' => ['name' => 'Test S.R.L']],
            ], 200),
        ]);

        $api = new ReceivedDocument();
        $response = $api->bin($documentId);

        expect($response)->toBeInstanceOf(ReceivedDocumentEntity::class)
            ->and($response->id)->toBe($documentId);
    });

    it('handles error on bin document', function () {
        Http::fake([
            'c/*/bin/received_documents/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new ReceivedDocument();
        $response = $api->bin(999);

        expect($response)->toBeInstanceOf(Error::class);
    });
});
