<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocument as IssuedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentAttachment;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentEmail;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentPagination;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentPreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentScheduleEmail;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocumentFakeResponse;

describe('Issued Document Entity', function () {
    it('lists issued documents', function () {
        $type = 'invoice';

        Http::fake([
            '*/issued_documents?type='.$type => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
            ),
        ]);

        $issuedDocuments = new IssuedDocument();
        $response = $issuedDocuments->list($type);

        expect($response)->toBeInstanceOf(IssuedDocumentList::class)
            ->getPagination()->toBeInstanceOf(IssuedDocumentPagination::class)
            ->getItems()->toBeArray()->toHaveCount(2)
            ->getItems()->{0}->toBeInstanceOf(IssuedDocumentEntity::class);
    });

    it('returns all issued documents', function () {
        $type = 'invoice';

        Http::fake([
            '*/issued_documents?type='.$type => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeAll()
            ),
        ]);

        $issuedDocuments = new IssuedDocument();
        $response = $issuedDocuments->all($type);

        expect($response)->toBeArray()->toHaveCount(2)
            ->{0}->toBeInstanceOf(IssuedDocumentEntity::class);
    });

    it('handles query parameters parsing in pagination', function () {
        $pagination = new IssuedDocumentPagination((object) []);

        $queryParams = $pagination->getParsedQueryParams('https://fake_url.com/entity?first=Lorem&type=document_type&second=Ipsum');

        expect($queryParams)->toBeObject()
            ->type->toBe('document_type')
            ->additional_data->toBeArray()->toHaveCount(2);
    });

    it('gets document detail', function () {
        $documentId = 1;

        Http::fake([
            '*/issued_documents/'.$documentId => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakeDetail()
            ),
        ]);

        $issuedDocuments = new IssuedDocument();
        $response = $issuedDocuments->detail($documentId);

        expect($response)->toBeInstanceOf(IssuedDocumentEntity::class);
    });

    it('deletes a document', function () {
        $documentId = 1;

        Http::fake([
            '*/issued_documents/'.$documentId => Http::response(),
        ]);

        $issuedDocuments = new IssuedDocument();
        $response = $issuedDocuments->delete($documentId);

        expect($response)->toBe('Document deleted');
    });

    it('creates a document', function () {
        $entityName = 'Test S.R.L';

        Http::fake([
            '*/issued_documents' => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakeDetail([
                    'entity' => [
                        'name' => $entityName,
                    ],
                ])
            ),
        ]);

        $issuedDocument = new IssuedDocument();
        $response = $issuedDocument->create([
            'data' => [
                'type' => 'invoice',
                'entity' => [
                    'name' => $entityName,
                ],
            ],
        ]);

        expect($response)->toBeInstanceOf(IssuedDocumentEntity::class);
    });

    it('validates document creation', function () {
        $api = new IssuedDocument();
        $response = $api->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('gets pre-create info', function () {
        $type = 'invoice';

        Http::fake([
            '*/issued_documents/info?type='.$type => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakePreCreateInfo()
            ),
        ]);

        $api = new IssuedDocument();
        $response = $api->preCreateInfo($type);

        expect($response)->toBeInstanceOf(IssuedDocumentPreCreateInfo::class);
    });

    it('gets email data', function () {
        $documentId = 1;

        Http::fake([
            '*/issued_documents/'.$documentId.'/email' => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakEmailData()
            ),
        ]);

        $api = new IssuedDocument();
        $response = $api->emailData($documentId);

        expect($response)->toBeInstanceOf(IssuedDocumentEmail::class);
    });

    it('schedules an email', function () {
        $documentId = 1;

        Http::fake([
            '*/issued_documents/'.$documentId.'/email' => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakScheduleEmail()
            ),
        ]);

        $api = new IssuedDocument();
        $response = $api->scheduleEmail($documentId, [
            'data' => [
                'sender_email' => 'fake_sender@gmail.com',
                'recipient_email' => 'fake_recipient@gmail.com',
                'subject' => 'Subject',
                'body' => 'Body',
                'include' => [
                    'document' => true,
                    'delivery_note' => false,
                    'attachment' => false,
                    'accompanying_invoice' => false,
                ],
                'attach_pdf' => false,
                'send_copy' => true,
            ],
        ]);

        expect($response)->toBeInstanceOf(IssuedDocumentScheduleEmail::class);
    });

    it('uploads an attachment', function () {
        Http::fake([
            '*/issued_documents/attachment' => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakScheduleAttachment()
            ),
        ]);

        $api = new IssuedDocument();
        $response = $api->attachment([
            'filename' => 'test.pdf',
            'attachment' => 'content',
        ]);

        expect($response)->toBeInstanceOf(IssuedDocumentAttachment::class);
    });

    it('deletes an attachment', function () {
        $documentId = 1;

        Http::fake([
            '*/issued_documents/'.$documentId.'/attachment' => Http::response(),
        ]);

        $api = new IssuedDocument();
        $response = $api->deleteAttachment($documentId);

        expect($response)->toBe('Attachment deleted');
    });
});
