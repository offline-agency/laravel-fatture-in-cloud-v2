<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocument as IssuedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentAttachment;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentEmail;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentPagination;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentPreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentScheduleEmail;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentTotals;
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

    it('handles error on list issued documents', function () {
        Http::fake([
            'c/*/issued_documents*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new IssuedDocument();
        $response = $api->list('invoice');

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on all issued documents', function () {
        Http::fake([
            'c/*/issued_documents*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new IssuedDocument();
        $response = $api->all('invoice');

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on document detail', function () {
        Http::fake([
            'c/*/issued_documents/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new IssuedDocument();
        $response = $api->detail(999);

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on delete document', function () {
        Http::fake([
            'c/*/issued_documents/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new IssuedDocument();
        $response = $api->delete(999);

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on create document', function () {
        Http::fake([
            'c/*/issued_documents' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new IssuedDocument();
        $response = $api->create([
            'data' => [
                'type' => 'invoice',
                'entity' => ['name' => 'Test S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('edits a document', function () {
        $documentId = 1;

        Http::fake([
            'c/*/issued_documents/'.$documentId => Http::response([
                'data' => [
                    'id' => $documentId,
                    'type' => 'invoice',
                    'entity' => ['name' => 'Updated S.R.L'],
                ],
            ], 200),
        ]);

        $api = new IssuedDocument();
        $response = $api->edit($documentId, [
            'data' => [
                'entity' => ['name' => 'Updated S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(IssuedDocumentEntity::class);
    });

    it('validates on edit document - missing data', function () {
        $api = new IssuedDocument();
        $response = $api->edit(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.entity.name on edit document', function () {
        $api = new IssuedDocument();
        $response = $api->edit(1, [
            'data' => ['type' => 'invoice'],
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.entity.name');
    });

    it('handles error on edit document', function () {
        Http::fake([
            'c/*/issued_documents/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new IssuedDocument();
        $response = $api->edit(1, [
            'data' => ['entity' => ['name' => 'Test S.R.L']],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets new totals', function () {
        Http::fake([
            'c/*/issued_documents/totals' => Http::response([
                'data' => [
                    'amount_net' => 100.0,
                    'amount_vat' => 22.0,
                    'amount_gross' => 122.0,
                ],
            ], 200),
        ]);

        $api = new IssuedDocument();
        $response = $api->getNewTotals([
            'data' => [
                'type' => 'invoice',
                'entity' => ['name' => 'Test S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(IssuedDocumentTotals::class);
    });

    it('validates on get new totals - missing data', function () {
        $api = new IssuedDocument();
        $response = $api->getNewTotals([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.entity.name on get new totals', function () {
        $api = new IssuedDocument();
        $response = $api->getNewTotals([
            'data' => ['type' => 'invoice'],
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.entity.name');
    });

    it('handles error on get new totals', function () {
        Http::fake([
            'c/*/issued_documents/totals' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new IssuedDocument();
        $response = $api->getNewTotals([
            'data' => [
                'type' => 'invoice',
                'entity' => ['name' => 'Test S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets existing totals', function () {
        $documentId = 1;

        Http::fake([
            'c/*/issued_documents/'.$documentId.'/totals' => Http::response([
                'data' => [
                    'amount_net' => 100.0,
                    'amount_vat' => 22.0,
                    'amount_gross' => 122.0,
                ],
            ], 200),
        ]);

        $api = new IssuedDocument();
        $response = $api->getExistingTotals($documentId, [
            'data' => [
                'entity' => ['name' => 'Test S.R.L'],
            ],
        ]);

        expect($response)->toBeInstanceOf(IssuedDocumentTotals::class);
    });

    it('validates on get existing totals - missing data', function () {
        $api = new IssuedDocument();
        $response = $api->getExistingTotals(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('handles error on get existing totals', function () {
        Http::fake([
            'c/*/issued_documents/*/totals' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new IssuedDocument();
        $response = $api->getExistingTotals(1, [
            'data' => ['entity' => ['name' => 'Test S.R.L']],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on pre-create info', function () {
        Http::fake([
            'c/*/issued_documents/info*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new IssuedDocument();
        $response = $api->preCreateInfo('invoice');

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on email data', function () {
        Http::fake([
            'c/*/issued_documents/*/email' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new IssuedDocument();
        $response = $api->emailData(999);

        expect($response)->toBeInstanceOf(Error::class);
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

    it('validates on schedule email - missing data', function () {
        $api = new IssuedDocument();
        $response = $api->scheduleEmail(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('handles error on schedule email', function () {
        Http::fake([
            'c/*/issued_documents/*/email' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new IssuedDocument();
        $response = $api->scheduleEmail(1, [
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

        expect($response)->toBeInstanceOf(Error::class);
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

    it('validates on attachment upload - missing filename', function () {
        $api = new IssuedDocument();
        $response = $api->attachment([
            'attachment' => 'content',
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('filename');
    });

    it('handles error on attachment upload', function () {
        Http::fake([
            'c/*/issued_documents/attachment' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new IssuedDocument();
        $response = $api->attachment([
            'filename' => 'test.pdf',
            'attachment' => 'content',
        ]);

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on delete attachment', function () {
        Http::fake([
            'c/*/issued_documents/*/attachment' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new IssuedDocument();
        $response = $api->deleteAttachment(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets bin document', function () {
        $documentId = 1;

        Http::fake([
            'c/*/bin/issued_documents/'.$documentId => Http::response([
                'data' => ['id' => $documentId, 'type' => 'invoice', 'entity' => ['name' => 'Test S.R.L']],
            ], 200),
        ]);

        $api = new IssuedDocument();
        $response = $api->bin($documentId);

        expect($response)->toBeInstanceOf(IssuedDocumentEntity::class)
            ->and($response->id)->toBe($documentId);
    });

    it('handles error on bin document', function () {
        Http::fake([
            'c/*/bin/issued_documents/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new IssuedDocument();
        $response = $api->bin(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('handles binDetail when document is found directly', function () {
        $documentId = 1;

        Http::fake([
            'c/*/issued_documents/'.$documentId => Http::response([
                'data' => ['id' => $documentId, 'type' => 'invoice', 'entity' => ['name' => 'Test S.R.L']],
            ], 200),
        ]);

        $api = new IssuedDocument();
        $response = $api->binDetail($documentId);

        expect($response)->toBeInstanceOf(IssuedDocumentEntity::class);
    });

    it('handles binDetail falling back to bin', function () {
        $documentId = 1;

        Http::fake([
            'c/*/bin/issued_documents/'.$documentId => Http::response([
                'data' => ['id' => $documentId, 'type' => 'invoice', 'entity' => ['name' => 'Test S.R.L']],
            ], 200),
            'c/*/issued_documents/'.$documentId => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new IssuedDocument();
        $response = $api->binDetail($documentId);

        expect($response)->toBeInstanceOf(IssuedDocumentEntity::class);
    });

    it('handles binDetail when both detail and bin fail', function () {
        Http::fake([
            'c/*/issued_documents/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
            'c/*/bin/issued_documents/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new IssuedDocument();
        $response = $api->binDetail(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('validates data.type on create document', function () {
        $api = new IssuedDocument();
        $response = $api->create([
            'data' => ['type' => 'invalid_type', 'entity' => ['name' => 'Test']],
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.type');
    });

    it('validates data.type on get new totals', function () {
        $api = new IssuedDocument();
        $response = $api->getNewTotals([
            'data' => ['type' => 'invalid_type', 'entity' => ['name' => 'Test']],
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.type');
    });

    it('handles null constructor parameter', function () {
        $entity = new IssuedDocumentEntity(null);

        expect($entity->id)->toBeNull()
            ->and($entity->type)->toBeNull();
    });

    it('navigates issued document list to next page', function () {
        $list = new IssuedDocumentList(json_decode(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList([
                'next_page_url' => 'https://fake_url/issued_documents?type=invoice&per_page=10&page=2',
            ])
        ));

        Http::fake(['c/*/issued_documents*' => Http::response(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
        )]);

        expect($list->getPagination()->goToNextPage())->toBeInstanceOf(IssuedDocumentList::class);
    });

    it('returns null navigating issued document list to next page when no next page url', function () {
        $list = new IssuedDocumentList(json_decode(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList(['next_page_url' => null])
        ));

        expect($list->getPagination()->goToNextPage())->toBeNull();
    });

    it('navigates issued document list to previous page', function () {
        $list = new IssuedDocumentList(json_decode(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList([
                'prev_page_url' => 'https://fake_url/issued_documents?type=invoice&per_page=10&page=1',
            ])
        ));

        Http::fake(['c/*/issued_documents*' => Http::response(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
        )]);

        expect($list->getPagination()->goToPrevPage())->toBeInstanceOf(IssuedDocumentList::class);
    });

    it('returns null navigating issued document list to previous page when no prev page url', function () {
        $list = new IssuedDocumentList(json_decode(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
        ));

        expect($list->getPagination()->goToPrevPage())->toBeNull();
    });

    it('navigates issued document list to first page', function () {
        $list = new IssuedDocumentList(json_decode(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList([
                'first_page_url' => 'https://fake_url/issued_documents?type=invoice&per_page=10&page=1',
            ])
        ));

        Http::fake(['c/*/issued_documents*' => Http::response(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
        )]);

        expect($list->getPagination()->goToFirstPage())->toBeInstanceOf(IssuedDocumentList::class);
    });

    it('returns null navigating issued document list to first page when no first page url', function () {
        $list = new IssuedDocumentList(json_decode(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList(['first_page_url' => null])
        ));

        expect($list->getPagination()->goToFirstPage())->toBeNull();
    });

    it('navigates issued document list to last page', function () {
        $list = new IssuedDocumentList(json_decode(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList([
                'last_page_url' => 'https://fake_url/issued_documents?type=invoice&per_page=10&page=5',
            ])
        ));

        Http::fake(['c/*/issued_documents*' => Http::response(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
        )]);

        expect($list->getPagination()->goToLastPage())->toBeInstanceOf(IssuedDocumentList::class);
    });

    it('returns null navigating issued document list to last page when no last page url', function () {
        $list = new IssuedDocumentList(json_decode(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList(['last_page_url' => null])
        ));

        expect($list->getPagination()->goToLastPage())->toBeNull();
    });
});
