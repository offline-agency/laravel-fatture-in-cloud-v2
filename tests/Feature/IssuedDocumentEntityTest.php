<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocumentFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Document\IssuedDocument as IssuedDocumentEntity;

class IssuedDocumentEntityTest extends TestCase
{
    public function test_issued_documents_list()
    {
        $company_id = 1;
        $type = 'invoice';

        Http::fake([
            $company_id . '/issued_documents?type=' . $type => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
            ),
        ]);

        $issued_documents = new IssuedDocument();
        $response = $issued_documents->list($type);

        $this->assertIsArray($response);
        $this->assertCount(2, $response);
    }

    public function test_issued_document_detail()
    {
        $company_id = 1;
        $document_id = 1;

        Http::fake([
            $company_id . '/issued_documents/' . $document_id => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentFakeDetail()
            ),
        ]);

        $issued_documents = new IssuedDocument();
        $response = $issued_documents->detail($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedDocumentEntity::class, $response);
    }
}
