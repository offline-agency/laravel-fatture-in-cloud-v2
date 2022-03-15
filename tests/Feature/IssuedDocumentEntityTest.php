<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class IssuedDocumentEntityTest extends TestCase
{
    public function test_issued_documents_list()
    {
        $company_id = 'fake_company_id';

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . config('fatture-in-cloud-v2.bearer'),
        ])->get('https://api-v2.fattureincloud.it/c/' . $company_id . '/issued_documents', [
            'type' => 'invoice',
        ]);

        $this->assertEquals(200, $response->status());
    }
}
