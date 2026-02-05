<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\ReceivedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocument as ReceivedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentPagination;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentPreCreateInfo;
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

    it('deletes a document', function () {
        $documentId = 1;

        Http::fake([
            '*/received_documents/'.$documentId => Http::response(),
        ]);

        $api = new ReceivedDocument();
        $response = $api->delete($documentId);

        expect($response)->toBe('Document deleted');
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

    it('deletes an attachment', function () {
        $documentId = 1;

        Http::fake([
            '*/received_documents/'.$documentId.'/attachment' => Http::response(),
        ]);

        $api = new ReceivedDocument();
        $response = $api->deleteAttachment($documentId);

        expect($response)->toBe('Attachment deleted');
    });
});
