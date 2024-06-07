<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Settings\TestPaymentAccount;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Settings\TestPaymentMethods;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Settings\TestTypeVat;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    public function testGetFakePaymentMethods()
    {
        $testPaymentMethods = new TestPaymentMethods();

        $result = $testPaymentMethods->getFakePaymentMethods([
            'id' => 1,
            'name' => 'TestName',
            'type' => 'TestType',
            'is_default' => true,
            'default_payment_account.id' => 100,
            'default_payment_account.name' => 'AccountName',
            'default_payment_account.type' => 'AccountType',
            'default_payment_account.iban' => 'IT60X0542811101000000123456',
            'default_payment_account.sia' => 'SIA123',
            'default_payment_account.cuc' => 'CUC123',
            'default_payment_account.virtual' => true,
            'details.title' => 'DetailTitle',
            'details.description' => 'DetailDescription',
            'bank_iban' => 'IT60X0542811101000000123456',
            'bank_name' => 'BankName',
            'ei_payment_method' => 'PaymentMethod'
        ]);

        $this->assertEquals(1, $result['id']);
        $this->assertEquals('TestName', $result['name']);
        $this->assertEquals('TestType', $result['type']);
        $this->assertTrue($result['is_default']);
        $this->assertEquals(100, $result['default_payment_account']['id']);
        $this->assertEquals('AccountName', $result['default_payment_account']['name']);
        $this->assertEquals('AccountType', $result['default_payment_account']['type']);
        $this->assertEquals('IT60X0542811101000000123456', $result['default_payment_account']['iban']);
        $this->assertEquals('SIA123', $result['default_payment_account']['sia']);
        $this->assertEquals('CUC123', $result['default_payment_account']['cuc']);
        $this->assertTrue($result['default_payment_account']['virtual']);
        $this->assertEquals('DetailTitle', $result['details']['title']);
        $this->assertEquals('DetailDescription', $result['details']['description']);
        $this->assertEquals('IT60X0542811101000000123456', $result['bank_iban']);
        $this->assertEquals('BankName', $result['bank_name']);
        $this->assertEquals('PaymentMethod', $result['ei_payment_method']);
    }

    public function testGetFakePaymentAccount()
    {
        $testPaymentAccount = new TestPaymentAccount();

        $result = $testPaymentAccount->getFakePaymentAccount([
            'id' => 2,
            'name' => 'TestName',
            'type' => 'TestType',
            'iban' => 'IT60X0542811101000000123456',
            'sia' => 'SIA123',
            'cuc' => 'CUC123',
            'virtual' => true,
        ]);

        $this->assertEquals(2, $result['id']);
        $this->assertEquals('TestName', $result['name']);
        $this->assertEquals('TestType', $result['type']);
        $this->assertEquals('IT60X0542811101000000123456', $result['iban']);
        $this->assertEquals('SIA123', $result['sia']);
        $this->assertEquals('CUC123', $result['cuc']);
        $this->assertTrue($result['virtual']);
    }

    public function testGetFakeVatType()
    {
        $testVatType = new TestTypeVat();

        $result = $testVatType->getFakeVatType([
            'id' => 3,
            'value' => 5.2,
            'description' => 'A description',
            'notes' => 'A note',
            'e_invoice' => true,
            'ei_type' => 'Wood',
            'editable' => false,
            'is_disabled' => false,
        ]);

        $this->assertEquals(3, $result['id']);
        $this->assertEquals(5.2, $result['value']);
        $this->assertEquals('A description', $result['description']);
        $this->assertEquals('A note', $result['notes']);
        $this->assertTrue($result['e_invoice']);
        $this->assertEquals('Wood', $result['ei_type']);
        $this->assertFalse($result['editable']);
        $this->assertFalse($result['is_disabled']);
    }
}
