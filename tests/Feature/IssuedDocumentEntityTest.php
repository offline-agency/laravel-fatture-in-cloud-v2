<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

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
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class IssuedDocumentEntityTest extends TestCase
{
    // list

    public function test_list_issued_documents()
    {
        $type = 'invoice';

        Http::fake([
            'issued_documents?type='.$type => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
            ),
        ]);

        $issued_documents = new IssuedDocument();
        $response = $issued_documents->list($type);

        $this->assertInstanceOf(IssuedDocumentList::class, $response);
        $this->assertInstanceOf(IssuedDocumentPagination::class, $response->getPagination());
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(IssuedDocumentEntity::class, $response->getItems()[0]);
    }

    public function test_error_on_list_issued_documents()
    {
        $type = 'invoice';

        Http::fake([
            'issued_documents?type='.$type => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakeError(),
                401
            ),
        ]);

        $issued_documents = new IssuedDocument();
        $response = $issued_documents->list($type);

        $this->assertInstanceOf(Error::class, $response);
    }

    // pagination

    public function test_query_parameters_parsing()
    {
        $issued_document_pagination = new IssuedDocumentPagination((object) []);

        $query_params = $issued_document_pagination->getParsedQueryParams('https://fake_url.com/entity?first=Lorem&type=document_type&second=Ipsum');

        $this->assertIsObject($query_params);

        $this->assertObjectHasAttribute('type', $query_params);
        $this->assertObjectHasAttribute('additional_data', $query_params);

        $this->assertEquals('document_type', $query_params->type);
        $this->assertIsArray($query_params->additional_data);
        $this->assertCount(2, $query_params->additional_data);
    }

    public function test_go_to_issued_document_next_page()
    {
        $type = 'invoice';

        $issued_document_list = new IssuedDocumentList(json_decode(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList([
                'next_page_url' => 'https://fake_url/issued_documents?type='.$type.'&per_page=10&page=2',
            ])
        ));

        Http::fake([
            'issued_documents?per_page=10&page=2&type='.$type => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
            ),
        ]);

        $next_page_response = $issued_document_list->getPagination()->goToNextPage();

        $this->assertInstanceOf(IssuedDocumentList::class, $next_page_response);
    }

    public function test_go_to_issued_document_prev_page()
    {
        $type = 'invoice';

        $issued_document_list = new IssuedDocumentList(json_decode(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList([
                'prev_page_url' => 'https://fake_url/issued_documents?type='.$type.'&per_page=10&page=1',
            ])
        ));

        Http::fake([
            'issued_documents?per_page=10&page=1&type='.$type => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
            ),
        ]);

        $prev_page_response = $issued_document_list->getPagination()->goToPrevPage();

        $this->assertInstanceOf(IssuedDocumentList::class, $prev_page_response);
    }

    public function test_go_to_issued_document_first_page()
    {
        $type = 'invoice';

        $issued_document_list = new IssuedDocumentList(json_decode(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList([
                'first_page_url' => 'https://fake_url/issued_documents?type='.$type.'&per_page=10&page=1',
            ])
        ));

        Http::fake([
            'issued_documents?per_page=10&page=1&type='.$type => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
            ),
        ]);

        $first_page_response = $issued_document_list->getPagination()->goToFirstPage();

        $this->assertInstanceOf(IssuedDocumentList::class, $first_page_response);
    }

    public function test_go_to_issued_document_last_page()
    {
        $type = 'invoice';

        $issued_document_list = new IssuedDocumentList(json_decode(
            (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList([
                'last_page_url' => 'https://fake_url/issued_documents?type='.$type.'&per_page=10&page=2',
            ])
        ));

        Http::fake([
            'issued_documents?per_page=10&page=2&type='.$type => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
            ),
        ]);

        $last_page_response = $issued_document_list->getPagination()->goToLastPage();

        $this->assertInstanceOf(IssuedDocumentList::class, $last_page_response);
    }

    // single

    public function test_detail_issued_document()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakeDetail()
            ),
        ]);

        $issued_documents = new IssuedDocument();
        $response = $issued_documents->detail($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedDocumentEntity::class, $response);
    }

    public function test_bin_issued_document()
    {
        $document_id = 1;

        Http::fake([
            'bin/issued_documents/'.$document_id => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakeDetail()
            ),
        ]);

        $issued_documents = new IssuedDocument();
        $response = $issued_documents->bin($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedDocumentEntity::class, $response);
    }

    public function test_delete_issued_document()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id => Http::response(),
        ]);

        $issued_documents = new IssuedDocument();
        $response = $issued_documents->delete($document_id);

        $this->assertEquals('Document deleted', $response);
    }

    public function test_issued_document_bin_detail()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakeDetail()
            ),
        ]);

        $issued_documents = new IssuedDocument();
        $response = $issued_documents->binDetail($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedDocumentEntity::class, $response);
    }

    // create

    public function test_create_issued_document()
    {
        $entity_name = 'Test S.R.L';

        Http::fake([
            'issued_documents' => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakeDetail([
                    'entity' => [
                        'name' => $entity_name,
                    ],
                ])
            ),
        ]);

        $issued_document = new IssuedDocument();
        $response = $issued_document->create([
            'data' => [
                'type' => 'invoice',
                'entity' => [
                    'name' => $entity_name,
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedDocumentEntity::class, $response);
    }

    public function test_validation_error_on_create_issued_document()
    {
        $issued_document = new IssuedDocument();
        $response = $issued_document->create([]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $issued_document = new IssuedDocument();
        $response = $issued_document->create([
            'data' => [],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());
        $this->assertArrayHasKey('data.type', $response->messages());
        $this->assertArrayHasKey('data.entity.name', $response->messages());

        $issued_document = new IssuedDocument();
        $response = $issued_document->create([
            'data' => [
                'type' => 'fake_type',
                'entity' => [
                    'name' => 'Test S.R.L.',
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.type', $response->messages());

        $issued_document = new IssuedDocument();
        $response = $issued_document->create([
            'data' => [
                'type' => 'invoice',
                'entity' => [],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.entity.name', $response->messages());
    }

    // edit

    public function test_edit_issued_document()
    {
        $document_id = 1;
        $entity_name = 'Test S.R.L Updated';

        Http::fake([
            'issued_documents/'.$document_id => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakeDetail([
                    'entity' => [
                        'name' => $entity_name,
                    ],
                ])
            ),
        ]);

        $issued_document = new IssuedDocument();
        $response = $issued_document->edit($document_id, [
            'data' => [
                'entity' => [
                    'name' => $entity_name,
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedDocumentEntity::class, $response);
    }

    public function test_validation_error_on_edit_issued_document()
    {
        $document_id = 1;

        $issued_document = new IssuedDocument();
        $response = $issued_document->edit($document_id, []);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $issued_document = new IssuedDocument();
        $response = $issued_document->edit($document_id, [
            'data' => [],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());
        $this->assertArrayHasKey('data.entity.name', $response->messages());

        $issued_document = new IssuedDocument();
        $response = $issued_document->edit($document_id, [
            'data' => [
                'entity' => [],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.entity.name', $response->messages());
    }

    // new totals

    public function test_get_new_totals_issued_document()
    {
        Http::fake([
            'issued_documents/totals' => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakeTotals()
            ),
        ]);

        $issued_document = new IssuedDocument();
        $response = $issued_document->getNewTotals([
            'data' => [
                'type' => 'invoice',
                'entity' => [
                    'name' => 'Test S.P.A',
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedDocumentTotals::class, $response);
    }

    public function test_validation_error_on_get_new_totals_issued_document()
    {
        $issued_document = new IssuedDocument();
        $response = $issued_document->getNewTotals([]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $issued_document = new IssuedDocument();
        $response = $issued_document->getNewTotals([
            'data' => [],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());
        $this->assertArrayHasKey('data.type', $response->messages());
        $this->assertArrayHasKey('data.entity.name', $response->messages());

        $issued_document = new IssuedDocument();
        $response = $issued_document->getNewTotals([
            'data' => [
                'type' => 'fake_type',
                'entity' => [
                    'name' => 'Test S.P.A.',
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.type', $response->messages());

        $issued_document = new IssuedDocument();
        $response = $issued_document->getNewTotals([
            'data' => [
                'type' => 'invoice',
                'entity' => [],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.entity.name', $response->messages());
    }

    // existing totals

    public function test_get_existing_totals_issued_document()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id.'/totals' => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakeTotals()
            ),
        ]);

        $issued_document = new IssuedDocument();
        $response = $issued_document->getExistingTotals($document_id, [
            'data' => [
                'entity' => [
                    'name' => 'Test S.R.L',
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedDocumentTotals::class, $response);
    }

    public function test_validation_error_on_get_existing_totals_issued_document()
    {
        $document_id = 1;

        $issued_document = new IssuedDocument();
        $response = $issued_document->getExistingTotals($document_id, []);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $issued_document = new IssuedDocument();
        $response = $issued_document->getExistingTotals($document_id, [
            'data' => [],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());
        $this->assertArrayHasKey('data.entity.name', $response->messages());

        $issued_document = new IssuedDocument();
        $response = $issued_document->getExistingTotals($document_id, [
            'data' => [
                'entity' => [],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.entity.name', $response->messages());
    }

    // info

    public function test_pre_create_info_issued_document()
    {
        $type = 'invoice';

        Http::fake([
            'issued_documents/info?type='.$type => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakePreCreateInfo()
            ),
        ]);

        $issued_document = new IssuedDocument();
        $response = $issued_document->preCreateInfo($type);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedDocumentPreCreateInfo::class, $response);
    }

    // emails

    public function test_email_data_issued_document()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id.'/email' => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakEmailData()
            ),
        ]);

        $issued_document = new IssuedDocument();
        $response = $issued_document->emailData($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedDocumentEmail::class, $response);
    }

    public function test_schedule_email_issued_document()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id.'/email' => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakScheduleEmail()
            ),
        ]);

        $issued_document = new IssuedDocument();
        $response = $issued_document->scheduleEmail($document_id, [
            'data' => [
                'sender_email' => 'fake_sender_email@gmail.com',
                'recipient_email' => 'fake_recipient_email@gmail.com',
                'subject' => 'fake_subject',
                'body' => 'fake_body',
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

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedDocumentScheduleEmail::class, $response);
    }

    public function test_validation_error_on_schedule_email_issued_document()
    {
        $document_id = 1;

        $issued_document = new IssuedDocument();
        $response = $issued_document->scheduleEmail($document_id, []);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $issued_document = new IssuedDocument();
        $response = $issued_document->scheduleEmail($document_id, [
            'data' => [
                'sender_email' => 'fake_email@gmail.com',
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayNotHasKey('data.sender_id', $response->messages());
        $this->assertArrayNotHasKey('data.sender_email', $response->messages());
        $this->assertArrayHasKey('data.recipient_email', $response->messages());
        $this->assertArrayHasKey('data.subject', $response->messages());
        $this->assertArrayHasKey('data.body', $response->messages());
        $this->assertArrayHasKey('data.include', $response->messages());
        $this->assertArrayHasKey('data.attach_pdf', $response->messages());
        $this->assertArrayHasKey('data.send_copy', $response->messages());

        $issued_document = new IssuedDocument();
        $response = $issued_document->scheduleEmail($document_id, [
            'data' => [
                'sender_email' => 'fake_email@gmail.com',
                'recipient_email' => 'fake_email@gmail.com',
                'subject' => 'fake_subject',
                'body' => 'fake_body',
                'attach_pdf' => 'fake_attach_pdf',
                'send_copy' => 'fake_send_copy',
                'include' => [
                    'document' => 'fake_document',
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.include.delivery_note', $response->messages());
        $this->assertArrayHasKey('data.include.attachment', $response->messages());
        $this->assertArrayHasKey('data.include.accompanying_invoice', $response->messages());
        $this->assertArrayNotHasKey('data.include.document', $response->messages());
    }

    // attachment

    public function test_attachment_issued_document()
    {
        Http::fake([
            'issued_documents/attachment' => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakScheduleAttachment()
            ),
        ]);

        $issued_document = new IssuedDocument();
        $response = $issued_document->attachment([
            'filename' => 'test-file.pdf',
            'attachment' => 'fake_attachment',
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedDocumentAttachment::class, $response);
    }

    public function test_validation_error_on_attachment_issued_document()
    {
        $issued_document = new IssuedDocument();
        $response = $issued_document->attachment([]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('filename', $response->messages());
        $this->assertArrayHasKey('attachment', $response->messages());
    }

    public function test_delete_attachment_issued_document()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id.'/attachment' => Http::response(),
        ]);

        $issued_document = new IssuedDocument();
        $response = $issued_document->deleteAttachment($document_id);

        $this->assertEquals('Attachment deleted', $response);
    }
}
