<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocument as IssuedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentPagination;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocumentFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class IssuedDocumentEntityTest extends TestCase
{
    // list

    public function test_list_issued_documents()
    {
        $type = 'invoice';

        Http::fake([
            'issued_documents?type=' . $type => Http::response(
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
            'issued_documents?type=' . $type => Http::response(
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
        $issued_document_pagination = new IssuedDocumentPagination((object)[]);

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
                'next_page_url' => 'https://fake_url/issued_documents?type=' . $type . '&per_page=10&page=2'
            ])
        ));

        Http::fake([
            'issued_documents?per_page=10&page=2&type=' . $type => Http::response(
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
                'prev_page_url' => 'https://fake_url/issued_documents?type=' . $type . '&per_page=10&page=1'
            ])
        ));

        Http::fake([
            'issued_documents?per_page=10&page=1&type=' . $type => Http::response(
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
                'first_page_url' => 'https://fake_url/issued_documents?type=' . $type . '&per_page=10&page=1'
            ])
        ));

        Http::fake([
            'issued_documents?per_page=10&page=1&type=' . $type => Http::response(
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
                'last_page_url' => 'https://fake_url/issued_documents?type=' . $type . '&per_page=10&page=2'
            ])
        ));

        Http::fake([
            'issued_documents?per_page=10&page=2&type=' . $type => Http::response(
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
            'issued_documents/' . $document_id => Http::response(
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
            'bin/issued_documents/' . $document_id => Http::response(
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
            'issued_documents/' . $document_id => Http::response(),
        ]);

        $issued_documents = new IssuedDocument();
        $response = $issued_documents->delete($document_id);

        $this->assertEquals('Document deleted', $response);
    }

    // create

    /*public function test_create_issued_document()
    {
        $issued_document = new IssuedDocument();
        $response = $issued_document->create([
            'data' => [
                'entity' => [
                    'name' => 'Test'
                ]
            ]
        ]);

        dd($response);
    }*/
}
