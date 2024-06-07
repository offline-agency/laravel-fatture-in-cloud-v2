<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\CashBook;
use PHPUnit\Framework\TestCase;

class CashBookTest extends TestCase
{
    public function testGetFakeCashBookEntry()
    {
        $testCashBookEntry = new CashBook\TestCashBook();

        $result = $testCashBookEntry->getFakeCashBook([
            'id' => 1675492,
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
                'id' => 456,
                'name' => 'Bank Account',
                'type' => 'bank',
                'iban' => 'IT60X0542811101000000123456',
                'sia' => '123456',
                'cuc' => 'ABCDEF',
                'virtual' => false,
            ],
            'amount_out' => 50.00,
            'payment_account_out' => [
                'id' => 789,
                'name' => 'Cash Wallet',
                'type' => 'standard',
                'iban' => null,
                'sia' => null,
                'cuc' => null,
                'virtual' => false,
            ],
        ]);

        $this->assertEquals(1675492, $result['id']);
        $this->assertEquals('2024-06-05', $result['date']);
        $this->assertEquals('A description', $result['description']);
        $this->assertEquals('cashbook', $result['kind']);
        $this->assertEquals('in', $result['type']);
        $this->assertEquals('John Cena', $result['entity_name']);
        $this->assertEquals(123, $result['document']['id']);
        $this->assertEquals('invoice', $result['document']['type']);
        $this->assertEquals('/path/to/document', $result['document']['path']);
        $this->assertEquals(100.00, $result['amount_in']);
        $this->assertEquals(456, $result['payment_account_in']['id']);
        $this->assertEquals('Bank Account', $result['payment_account_in']['name']);
        $this->assertEquals('bank', $result['payment_account_in']['type']);
        $this->assertEquals('IT60X0542811101000000123456', $result['payment_account_in']['iban']);
        $this->assertEquals('123456', $result['payment_account_in']['sia']);
        $this->assertEquals('ABCDEF', $result['payment_account_in']['cuc']);
        $this->assertFalse($result['payment_account_in']['virtual']);
        $this->assertEquals(50.00, $result['amount_out']);
        $this->assertEquals(789, $result['payment_account_out']['id']);
        $this->assertEquals('Cash Wallet', $result['payment_account_out']['name']);
        $this->assertEquals('standard', $result['payment_account_out']['type']);
        $this->assertNull($result['payment_account_out']['iban']);
        $this->assertNull($result['payment_account_out']['sia']);
        $this->assertNull($result['payment_account_out']['cuc']);
        $this->assertFalse($result['payment_account_out']['virtual']);
    }
}
