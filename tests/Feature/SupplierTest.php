<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Http;

class SupplierTest extends TestCase{
    public function test_list_supplier(){
        
        Http::fake([
            'suppliers' => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
            ),
        ])
        }

}