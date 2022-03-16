<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocumentFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class IssuedDocumentEntityTest extends TestCase
{
    public function test_issued_documents_list()
    {
        $company_id = 'fake_company_id';
        $type = 'invoice';

        Http::fake([
            $company_id . '/issued_documents?type=' . $type => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
            ),
        ]);

        $issued_documents = new IssuedDocument;
        $response = $issued_documents->list($company_id, $type);

        $this->assertIsArray($response);
        $this->assertCount(2, $response);
    }
}
