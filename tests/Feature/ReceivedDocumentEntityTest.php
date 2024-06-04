<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\ReceivedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocument as ReceivedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentPagination;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentPreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocumentFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class ReceivedDocumentEntityTest extends TestCase
{
    // list

    public function test_list_Received_documents()
    {
        $type = 'invoice';

        Http::fake([
            'Received_documents?type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentsFakeList()
            ),
        ]);

        $received_documents = new ReceivedDocument();
        $response = $received_documents->list($type);

        $this->assertInstanceOf(ReceivedDocumentList::class, $response);
        $this->assertInstanceOf(ReceivedDocumentPagination::class, $response->getPagination());
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(ReceivedDocumentEntity::class, $response->getItems()[0]);
    }

    public function test_all_documents()
    {
        $type = 'invoice';

        Http::fake([
            'Received_documents?type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentsFakeAll()
            ),
        ]);

        $received_documents = new ReceivedDocument();
        $response = $received_documents->all($type);

        $this->assertIsArray($response);
        $this->assertCount(2, $response);
        $this->assertInstanceOf(ReceivedDocumentEntity::class, $response[0]);
    }

    public function test_error_on_all_documents()
    {
        $type = 'invoice';

        Http::fake([
            'Received_documents?type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeError(),
                401
            ),
        ]);

        $received_documents = new ReceivedDocument();
        $response = $received_documents->all($type);

        $this->assertInstanceOf(Error::class, $response);
    }

    public function test_list_Received_documents_has_Received_documents_method()
    {
        $type = 'invoice';

        Http::fake([
            'Received_documents?type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentsFakeList()
            ),
        ]);

        $received_documents = new ReceivedDocument();
        $response = $received_documents->list($type);

        $this->assertTrue($response->hasItems());
    }

    public function test_empty_list_Received_documents_has_Received_documents_method()
    {
        $type = 'invoice';

        Http::fake([
            'Received_documents?type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getEmptyReceivedDocumentsFakeList()
            ),
        ]);

        $received_documents = new ReceivedDocument();
        $response = $received_documents->list($type);

        $this->assertFalse($response->hasItems());
    }

    public function test_error_on_list_Received_documents()
    {
        $type = 'invoice';

        Http::fake([
            'Received_documents?type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeError(),
                401
            ),
        ]);

        $received_documents = new ReceivedDocument();
        $response = $received_documents->list($type);

        $this->assertInstanceOf(Error::class, $response);
    }

    // pagination

    public function test_query_parameters_parsing()
    {
        $received_document_pagination = new ReceivedDocumentPagination((object) []);

        $query_params = $received_document_pagination->getParsedQueryParams('https://fake_url.com/entity?first=Lorem&type=document_type&second=Ipsum');

        $this->assertIsObject($query_params);

        $this->assertObjectHasAttribute('type', $query_params);
        $this->assertObjectHasAttribute('additional_data', $query_params);

        $this->assertEquals('document_type', $query_params->type);
        $this->assertIsArray($query_params->additional_data);
        $this->assertCount(2, $query_params->additional_data);
    }

    public function test_go_to_Received_document_next_page()
    {
        $type = 'invoice';

        $received_document_list = new ReceivedDocumentList(json_decode(
            (new ReceivedDocumentFakeResponse())->getReceivedDocumentsFakeList([
                'next_page_url' => 'https://fake_url/Received_documents?type='.$type.'&per_page=10&page=2',
            ])
        ));

        Http::fake([
            'Received_documents?per_page=10&page=2&type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentsFakeList()
            ),
        ]);

        $next_page_response = $received_document_list->getPagination()->goToNextPage();

        $this->assertInstanceOf(ReceivedDocumentList::class, $next_page_response);
    }

    public function test_go_to_Received_document_prev_page()
    {
        $type = 'invoice';

        $received_document_list = new ReceivedDocumentList(json_decode(
            (new ReceivedDocumentFakeResponse())->getReceivedDocumentsFakeList([
                'prev_page_url' => 'https://fake_url/Received_documents?type='.$type.'&per_page=10&page=1',
            ])
        ));

        Http::fake([
            'Received_documents?per_page=10&page=1&type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentsFakeList()
            ),
        ]);

        $prev_page_response = $received_document_list->getPagination()->goToPrevPage();

        $this->assertInstanceOf(ReceivedDocumentList::class, $prev_page_response);
    }

    public function test_go_to_Received_document_first_page()
    {
        $type = 'invoice';

        $received_document_list = new ReceivedDocumentList(json_decode(
            (new ReceivedDocumentFakeResponse())->getReceivedDocumentsFakeList([
                'first_page_url' => 'https://fake_url/Received_documents?type='.$type.'&per_page=10&page=1',
            ])
        ));

        Http::fake([
            'Received_documents?per_page=10&page=1&type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentsFakeList()
            ),
        ]);

        $first_page_response = $received_document_list->getPagination()->goToFirstPage();

        $this->assertInstanceOf(ReceivedDocumentList::class, $first_page_response);
    }

    public function test_go_to_Received_document_last_page()
    {
        $type = 'invoice';

        $received_document_list = new ReceivedDocumentList(json_decode(
            (new ReceivedDocumentFakeResponse())->getReceivedDocumentsFakeList([
                'last_page_url' => 'https://fake_url/Received_documents?type='.$type.'&per_page=10&page=2',
            ])
        ));

        Http::fake([
            'Received_documents?per_page=10&page=2&type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentsFakeList()
            ),
        ]);

        $last_page_response = $received_document_list->getPagination()->goToLastPage();

        $this->assertInstanceOf(ReceivedDocumentList::class, $last_page_response);
    }

    // single

    public function test_detail_Received_document()
    {
        $document_id = 1;

        Http::fake([
            'Received_documents/'.$document_id => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeDetail()
            ),
        ]);

        $received_documents = new ReceivedDocument();
        $response = $received_documents->detail($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceivedDocumentEntity::class, $response);
    }

    public function test_bin_Received_document()
    {
        $document_id = 1;

        Http::fake([
            'bin/Received_documents/'.$document_id => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeDetail()
            ),
        ]);

        $received_documents = new ReceivedDocument();
        $response = $received_documents->bin($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceivedDocumentEntity::class, $response);
    }

    public function test_delete_Received_document()
    {
        $document_id = 1;

        Http::fake([
            'Received_documents/'.$document_id => Http::response(),
        ]);

        $received_documents = new ReceivedDocument();
        $response = $received_documents->delete($document_id);

        $this->assertEquals('Document deleted', $response);
    }

    public function test_Received_document_bin_detail_from_detail()
    {
        $document_id = 1;

        Http::fake([
            'Received_documents/'.$document_id => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeDetail()
            ),
        ]);

        $received_documents = new ReceivedDocument();
        $response = $received_documents->binDetail($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceivedDocumentEntity::class, $response);
    }

    public function test_Received_document_bin_detail_from_bin()
    {
        $document_id = 1;

        Http::fake([
            'Received_documents/'.$document_id => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeDetail()
            ),
        ]);

        Http::fake([
            'Received_documents/'.$document_id.'?fields=id' => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeErrorDetail(),
                401
            ),
        ]);

        $received_documents = new ReceivedDocument();
        $response = $received_documents->binDetail($document_id, [
            'fields' => 'id',
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceivedDocumentEntity::class, $response);
    }

    // create

    public function test_create_Received_document()
    {
        $entity_name = 'Test S.R.L';

        Http::fake([
            'Received_documents' => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeDetail([
                    'entity' => [
                        'name' => $entity_name,
                    ],
                ])
            ),
        ]);

        $received_document = new ReceivedDocument();
        $response = $received_document->create([
            'data' => [
                'type' => 'invoice',
                'entity' => [
                    'name' => $entity_name,
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceivedDocumentEntity::class, $response);
    }

    public function test_validation_error_on_create_Received_document()
    {
        $received_document = new ReceivedDocument();
        $response = $received_document->create([]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $received_document = new ReceivedDocument();
        $response = $received_document->create([
            'data' => [],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());
        $this->assertArrayHasKey('data.type', $response->messages());
        $this->assertArrayHasKey('data.entity.name', $response->messages());

        $received_document = new ReceivedDocument();
        $response = $received_document->create([
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

        $received_document = new ReceivedDocument();
        $response = $received_document->create([
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

    public function test_edit_Received_document()
    {
        $document_id = 1;
        $entity_name = 'Test S.R.L Updated';

        Http::fake([
            'Received_documents/'.$document_id => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeDetail([
                    'entity' => [
                        'name' => $entity_name,
                    ],
                ])
            ),
        ]);

        $received_document = new ReceivedDocument();
        $response = $received_document->edit($document_id, [
            'data' => [
                'entity' => [
                    'name' => $entity_name,
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceivedDocumentEntity::class, $response);
    }

    public function test_validation_error_on_edit_Received_document()
    {
        $document_id = 1;

        $received_document = new ReceivedDocument();
        $response = $received_document->edit($document_id, []);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $received_document = new ReceivedDocument();
        $response = $received_document->edit($document_id, [
            'data' => [],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());
        $this->assertArrayHasKey('data.entity.name', $response->messages());

        $received_document = new ReceivedDocument();
        $response = $received_document->edit($document_id, [
            'data' => [
                'entity' => [],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.entity.name', $response->messages());
    }

    // new totals

    public function test_get_new_totals_Received_document()
    {
        Http::fake([
            'Received_documents/totals' => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeTotals()
            ),
        ]);

        $received_document = new ReceivedDocument();
        $response = $received_document->getNewTotals([
            'data' => [
                'type' => 'invoice',
                'entity' => [
                    'name' => 'Test S.P.A',
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceivedDocumentTotals::class, $response);
    }

    public function test_validation_error_on_get_new_totals_Received_document()
    {
        $received_document = new ReceivedDocument();
        $response = $received_document->getNewTotals([]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $received_document = new ReceivedDocument();
        $response = $received_document->getNewTotals([
            'data' => [],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());
        $this->assertArrayHasKey('data.type', $response->messages());
        $this->assertArrayHasKey('data.entity.name', $response->messages());

        $received_document = new ReceivedDocument();
        $response = $received_document->getNewTotals([
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

        $received_document = new ReceivedDocument();
        $response = $received_document->getNewTotals([
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

    public function test_get_existing_totals_Received_document()
    {
        $document_id = 1;

        Http::fake([
            'Received_documents/'.$document_id.'/totals' => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeTotals()
            ),
        ]);

        $received_document = new ReceivedDocument();
        $response = $received_document->getExistingTotals($document_id, [
            'data' => [
                'entity' => [
                    'name' => 'Test S.R.L',
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceivedDocumentTotals::class, $response);
    }

    public function test_validation_error_on_get_existing_totals_Received_document()
    {
        $document_id = 1;

        $received_document = new ReceivedDocument();
        $response = $received_document->getExistingTotals($document_id, []);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $received_document = new ReceivedDocument();
        $response = $received_document->getExistingTotals($document_id, [
            'data' => [],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());
        $this->assertArrayHasKey('data.entity.name', $response->messages());

        $received_document = new ReceivedDocument();
        $response = $received_document->getExistingTotals($document_id, [
            'data' => [
                'entity' => [],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.entity.name', $response->messages());
    }

    // info

    public function test_pre_create_info_Received_document()
    {
        $type = 'invoice';

        Http::fake([
            'Received_documents/info?type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakePreCreateInfo()
            ),
        ]);

        $received_document = new ReceivedDocument();
        $response = $received_document->preCreateInfo($type);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceivedDocumentPreCreateInfo::class, $response);
    }

    // emails

    public function test_email_data_Received_document()
    {
        $document_id = 1;

        Http::fake([
            'Received_documents/'.$document_id.'/email' => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakEmailData()
            ),
        ]);

        $received_document = new ReceivedDocument();
        $response = $received_document->emailData($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceivedDocumentEmail::class, $response);
    }

    public function test_schedule_email_Received_document()
    {
        $document_id = 1;

        Http::fake([
            'Received_documents/'.$document_id.'/email' => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakScheduleEmail()
            ),
        ]);

        $received_document = new ReceivedDocument();
        $response = $received_document->scheduleEmail($document_id, [
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
        $this->assertInstanceOf(ReceivedDocumentScheduleEmail::class, $response);
    }

    public function test_validation_error_on_schedule_email_Received_document()
    {
        $document_id = 1;

        $received_document = new ReceivedDocument();
        $response = $received_document->scheduleEmail($document_id, []);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $received_document = new ReceivedDocument();
        $response = $received_document->scheduleEmail($document_id, [
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

        $received_document = new ReceivedDocument();
        $response = $received_document->scheduleEmail($document_id, [
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

    public function test_attachment_Received_document()
    {
        Http::fake([
            'Received_documents/attachment' => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakScheduleAttachment()
            ),
        ]);

        $received_document = new ReceivedDocument();
        $response = $received_document->attachment([
            'filename' => 'test-file.pdf',
            'attachment' => 'fake_attachment',
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceivedDocumentAttachment::class, $response);
    }

    public function test_validation_error_on_attachment_Received_document()
    {
        $received_document = new ReceivedDocument();
        $response = $received_document->attachment([]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('filename', $response->messages());
        $this->assertArrayHasKey('attachment', $response->messages());
    }

    public function test_delete_attachment_Received_document()
    {
        $document_id = 1;

        Http::fake([
            'Received_documents/'.$document_id.'/attachment' => Http::response(),
        ]);

        $received_document = new ReceivedDocument();
        $response = $received_document->deleteAttachment($document_id);

        $this->assertEquals('Attachment deleted', $response);
    }
}
