<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocumentFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;
use Illuminate\Http\Request;
use OfflineAgency\LaravelFattureInCloudV2\Api\Setting;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentMethods;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentAccount;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\VatType;

class SettingsTest extends TestCase
{
    public function testCreatePaymentMethod()
    {
        $data = [
            'id' => 1,
            'name' => 'Test Payment Method',
            'type' => 'credit_card',
            'is_default' => true,
            'default_payment_account' => [
                'id' => 1,
                'name' => 'Default Account',
                'type' => 'bank_account',
                'iban' => 'IT60X0542811101000000123456',
                'sia' => 'ABCDEF',
                'cuc' => 'XYZ123',
                'virtual' => false
            ],
            'details' => [
                ['title' => 'Detail 1', 'description' => 'Description 1']
            ],
            'bank_iban' => 'IT60X0542811101000000123456',
            'bank_name' => 'Test Bank',
            'bank_beneficiary' => 'Test Beneficiary',
            'ei_payment_method' => 'ei_method',
        ];

        $request = Request::create('/api/settings/payment-method', 'POST', $data);
        $settingApi = new Setting();

        $response = $settingApi->createPaymentMethod($request);
dd($response);
        $this->assertEquals(201, $response->status());
        $this->assertEquals('Metodo di pagamento creato con successo', $response->getData()->message);
        $this->assertEquals(1, $response->getData()->payment_method_id);
    }

    public function testGetPaymentMethod()
    {


        Http::fake([
            'payment_methods' => Http::response(
                (new \OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\SettingFakeResponse())->getPaymentMethodFakeDetail()
            ),
        ]);

        $settingApi = new Setting();
        $response = $settingApi->getPaymentMethod(1);
        dd($response);
        $this->assertEquals(201, $response->status());
        $this->assertObjectHasProperty('payment_method', $response->getData());
    }


    public function testUpdatePaymentMethod()
    {
        $data = [
            'id' => 1,
            'name' => 'Updated Payment Method',
            'type' => 'bank_transfer',
            'is_default' => false,
            'default_payment_account' => [
                'id' => 1,
                'name' => 'Updated Default Account',
                'type' => 'bank_account',
                'iban' => 'IT60X0542811101000000123456',
                'sia' => 'ABCDEF',
                'cuc' => 'XYZ123',
                'virtual' => false
            ],
            'details' => [
                ['title' => 'Detail 1', 'description' => 'Updated Description 1']
            ],
            'bank_iban' => 'IT60X0542811101000000123456',
            'bank_name' => 'Updated Bank Name',
            'bank_beneficiary' => 'Updated Bank Beneficiary',
            'ei_payment_method' => 'updated_ei_method',
        ];

        $request = Request::create('/api/settings/update-payment-method', 'PUT', $data);
        $settingApi = new Setting();

        Http::fake([
            'update_payment_methods' => Http::response(['message' => 'Metodo di pagamento aggiornato con successo'], 201)
        ]);


        $response = $settingApi->updatePaymentMethod($request, 1);
dd($response);
        $this->assertEquals(201, $response->status());
        /*if ($response->status() === 400) {
            dd($response->getData());
        }*/
        $this->assertEquals('Metodo di pagamento aggiornato con successo', $response->getData()->message);
        $this->assertEquals(1, $response->getData()->payment_method_id);
    }

    public function testDeletePaymentMethod()
    {
        $paymentMethodId=1;

        Http::fake([
            'delete_payment_methods' => Http::response(),
        ]);

        $payMethod = new Setting();
        $response = $payMethod->deletePaymentMethod(1);
dd($response);
        $this->assertEquals(201, $response->status());
        $this->assertEquals('Metodo di pagamento eliminato con successo', $response->getData()->message);
    }


    // Test PaymentAccount


    public function testCreatePaymentAccount()
    {
        $data = [
            'id' => 1,
            'name' => 'Test Account',
            'type' => 'bank_account',
            'iban' => 'IT60X0542811101000000123456',
            'sia' => 'ABCDEF',
            'cuc' => 'XYZ123',
            'virtual' => false
        ];

        $request = Request::create('/api/settings/payment-account', 'POST', $data);
        $settingApi = new Setting();

        $response = $settingApi->createPaymentAccount($request);

        dd($response);
        $this->assertEquals(201, $response->status());
        $this->assertEquals('Account di pagamento creato con successo', $response->getData()->message);
    }

    public function testGetPaymentAccount()
    {
        Http::fake([
            'payment_account' => Http::response(
                (new \OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\SettingFakeResponse())->getPaymentAccountFakeDetail()
            ),
        ]);

        $settingApi = new Setting();
        $response = $settingApi->getPaymentAccount(1);
dd($response);
        $this->assertEquals(201, $response->status());
        $this->assertObjectHasProperty('payment_account', $response->getData());
    }

    public function testUpdatePaymentAccount()
    {
        $data = [
            'name' => 'Updated Account',
            'type' => 'bank_account',
            'iban' => 'IT60X0542811101000000123456',
            'sia' => 'ABCDEF',
            'cuc' => 'XYZ123',
            'virtual' => false
        ];

        $request = Request::create('/api/settings/payment-account/1', 'PUT', $data);
        $settingApi = new Setting();

        $response = $settingApi->updatePaymentAccount($request, 1);
        dd($response);
        $this->assertEquals(201, $response->status());
        $this->assertEquals('Account aggiornato con successo', $response->getData()->message);
    }

    public function testDeletePaymentAccount()
    {
        Http::fake([
            'delete_payment_account' => Http::response(),
        ]);

        $payAccount = new Setting();
        $response = $payAccount->deletePaymentAccount(1);
dd($response);
        $this->assertEquals(201, $response->status());
        $this->assertEquals('Account di pagamento eliminato con successo', $response->getData()->message);
    }


    // Test VatType


    public function testCreateVatType()
    {
        $data = [
            'id' => 1,
            'value' => 22.0,
            'description' => 'IVA 22%',
            'notes' => 'Note',
            'e_invoice' => true,
            'ei_type' => 'e_type',
            'ei_description' => 'e_description',
            'editable' => true,
            'is_disabled' => false
        ];

        $request = Request::create('/api/settings/vat-type', 'POST', $data);
        $settingApi = new Setting();

        $response = $settingApi->createVatType($request);
dd($response);
        $this->assertEquals(201, $response->status());
        $this->assertEquals('Tipo di IVA creato con successo', $response->getData()->message);
    }

    public function testGetVatType()
    {
        Http::fake([
            'vat_type' => Http::response(
                (new \OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\SettingFakeResponse())->getVatTypeFakeDetail()
            ),
        ]);

        $settingApi = new Setting();
        $response = $settingApi->getVatType(1);
dd($response);
        $this->assertEquals(200, $response->status());
        $this->assertObjectHasProperty('vat_type', $response->getData());
    }

    public function testUpdateVatType()
    {
        $data = [
            'value' => 10.0,
            'description' => 'IVA 10%',
            'notes' => 'Updated Notes',
            'e_invoice' => false,
            'ei_type' => 'updated_e_type',
            'ei_description' => 'updated_e_description',
            'editable' => false,
            'is_disabled' => true
        ];

        $request = Request::create('/api/settings/vat-type/1', 'PUT', $data);
        $settingApi = new Setting();

        $response = $settingApi->updateVatType($request, 1);
dd($response);
        $this->assertEquals(201, $response->status());
        $this->assertEquals('Tipo di IVA aggiornato con successo', $response->getData()->message);
    }

    public function testDeleteVatType()
    {
        Http::fake([
            'delete_tay_type' => Http::response(),
        ]);

        $vatTypeApi = new Setting();
        $response = $vatTypeApi->deleteVatType(1);
dd($response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals('Tipo di IVA eliminato con successo', $response->getData()->message);
    }
}
