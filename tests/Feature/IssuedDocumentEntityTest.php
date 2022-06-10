<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Document\IssuedDocument as IssuedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocumentFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class IssuedDocumentEntityTest extends TestCase
{
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

        $this->assertIsArray($response);
        $this->assertCount(2, $response);
    }

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
}

