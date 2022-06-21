<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Http;

class SupplierEntityTest extends TestCase{
    public function test_list_supplier_entity(){
        
        Http::fake([
            'suppliers' => Http::response(
                (new IssuedDocumentFakeResponse())->getIssuedDocumentsFakeList()
            ),
        ])
        }

}