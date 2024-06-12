<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\CashBook;
use OfflineAgency\LaravelFattureInCloudV2\Api\Cashbooks;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class CashBookTest extends TestCase
{
    public function testCreateFakeCashBookEntry()
    {
        $data = [
            'id' => 1,
            'date' => '2024-06-05',
            'description' => 'A description',
            'kind' => 'cashbook',
            'type' => 'in',
            'entity_name' => 'John Cena',
            'document' => [
                'id' => 123,
                'type' => 'invoice',
                'path' => '/path/to/document',
            ],
            'amount_in' => 100.00,
            'payment_account_in' => [
                'id' => 1,
                'name' => 'Bank Account',
                'type' => 'bank',
                'iban' => 'IT60X0542811101000000123456',
                'sia' => '123456',
                'cuc' => 'ABCDEF',
                'virtual' => false,
            ],
            'amount_out' => 50.00,
            'payment_account_out' => [
                'id' => 1,
                'name' => 'Cash Wallet',
                'type' => 'standard',
                'iban' => null,
                'sia' => null,
                'cuc' => null,
                'virtual' => false,
            ],
        ];

        $request = Request::create('/api/settings/cashbook-entry', 'POST', $data);dd('kj' )      ;

        $CashBookApi = new Cashbooks();

        $response = $CashBookApi->createCashBookEntry($request);

        $this->assertEquals(201, $response->status());

    }

    public function testGetFakeCashBookEntry(){

    }

    public function testEditFakeCashBookEntry(){

    }

    public function testDeleteFakeCashBookEntry(){

    }
}
