<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Settings;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\Settings as AccountEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\Settings as MethodEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\Settings as VatTypeEntity;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\SettingsFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class SettingsEntityTest extends TestCase
{
    public function test_create_payment_method()
    {
        Http::fake([
            'settings/payment_methods' => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail()
            ),
        ]);

        $settings = new Settings();
        $response = $settings->mCreate([
            'data' => [
                'name' => 'Test',
                'default_payment_account' => [
                    'name' => 'test'
                ]
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MethodEntity::class, $response);
    }

    public function test_validation_error_on_create_payment_method()
    {
        Http::fake([
            'settings/payment_methods' => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail()
            ),
        ]);

        $settings = new Settings();
        $response = $settings->mCreate([]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $settings = new Settings();
        $response = $settings->mCreate([
            'data' => [
                'value' => '1',
            ],
        ]);
        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
    }

    public function test_detail_payment_method()
    {
        $payment_method_id = 1;

        Http::fake([
            'settings/payment_methods'.$payment_method_id => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail()
            ),
        ]);

        $settings = new Settings();
        $response = $settings->mDetail($payment_method_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MethodEntity::class, $response);
    }

    public function test_edit_payment_method()
    {
        $payment_method_id = 1;
        $setting_name = 'Test Updated';

        Http::fake([
            'settings/payment_methods/' . $payment_method_id => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail([
                    'data' => [
                        'name' => 'Test',
                        'default_payment_account' => [
                            'name' => 'test'
                        ]
                    ],
                ])
            ),
        ]);

        $settings = new Settings();
        $response = $settings->mEdit($payment_method_id, [
            'data' => [
                'name' => 'Test',
                'default_payment_account' => [
                    'name' => 'test'
                ]
            ],
            'data_s' => [
                'name' => $setting_name,
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MethodEntity::class, $response);
    }

    public function test_validation_error_on_edit_payment_method()
    {
        $payment_method_id = 1;

        Http::fake([
            'settings/payment_methods'.$payment_method_id => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail()
            ),
        ]);

        $settings = new Settings();
        $response = $settings->mEdit($payment_method_id, []);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $settings = new Settings();
        $response = $settings->mEdit($payment_method_id, [
            'data' => [
                'code' => 'test',
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.name', $response->messages());
    }

    public function test_delete_payment_method()
    {
        $payment_method_id = 1;

        Http::fake([
            'settings/payment_methods/' . $payment_method_id => Http::response(),
        ]);

        $settings = new Settings();
        $response = $settings->mDelete($payment_method_id);

        $this->assertEquals('Payment method deleted', $response);
    }

    //Payment Account

    public function test_create_payment_account()
    {
        Http::fake([
            'settings/payment_accounts' => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail()
            ),
        ]);

        $settings = new Settings();
        $response = $settings->aCreate([
            'data' => [
                'name' => 'Test',
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(AccountEntity::class, $response);
    }

    public function test_validation_error_on_create_payment_account()
    {
        Http::fake([
            'settings/payment_accounts' => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail()
            ),
        ]);

        $settings = new Settings();
        $response = $settings->aCreate([]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $settings = new Settings();
        $response = $settings->aCreate([
            'data' => [
                'value' => '1',
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
    }

    public function test_detail_payment_account()
    {
        $payment_account_id = 1;

        Http::fake([
            'settings/payment_accounts'.$payment_account_id => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail()
            ),
        ]);

        $settings = new Settings();
        $response = $settings->aDetail($payment_account_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(AccountEntity::class, $response);
    }


    public function test_edit_payment_account()
    {
        $payment_account_id = 1;
        $setting_name = 'Test Updated';

        Http::fake([
            'settings/payment_accounts/' . $payment_account_id => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail([
                    'name' => $setting_name,
                ])
            ),
        ]);

        $settings = new Settings();
        $response = $settings->aEdit($payment_account_id, [
            'data' => [
                'name' => $setting_name,
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(AccountEntity::class, $response);
    }

    public function test_validation_error_on_edit_payment_account()
    {
        $payment_account_id = 1;

        Http::fake([
            'settings/payment_accounts'.$payment_account_id => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail()
            ),
        ]);

        $settings = new Settings();
        $response = $settings->mEdit($payment_account_id, []);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $settings = new Settings();
        $response = $settings->mEdit($payment_account_id, [
            'data' => [
                'code' => 'test',
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.name', $response->messages());
    }

    public function test_delete_payment_account()
    {
        $payment_account_id = 1;

        Http::fake([
            'settings/payment_accounts/' . $payment_account_id => Http::response(),
        ]);

        $settings = new Settings();
        $response = $settings->aDelete($payment_account_id);

        $this->assertEquals('Payment method deleted', $response);
    }

    //Vat_Type

    public function test_create_vat_type()
    {
        Http::fake([
            'settings/vat_types' => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail()
            ),
        ]);

        $settings = new Settings();
        $response = $settings->vtCreate([
            'data' => [
                'value' => 1,
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
    }

    public function test_validation_error_on_create_vat_type()
    {
        $settings = new Settings();
        $response = $settings->vtCreate([]);

        Http::fake([
            'settings/vat_types' => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail()
            ),
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $settings = new Settings();
        $response = $settings->vtCreate([
            'data' => [
                'value' => 1,
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
    }

    public function test_detail_vat_type()
    {
        $vat_type_id = 1;

        Http::fake([
            'settings/vat_types'.$vat_type_id => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail()
            ),
        ]);

        $settings = new Settings();
        $response = $settings->vtDetail($vat_type_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(VatTypeEntity::class, $response);
    }


    public function test_edit_vat_type()
    {
        $vat_type_id = 1;
        $setting_name = 'Test Updated';

        Http::fake([
            'settings/vat_types/' . $vat_type_id => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail([
                    'name' => $setting_name,
                ])
            ),
        ]);

        $settings = new Settings();
        $response = $settings->vtEdit($vat_type_id, [
            'data' => [
                'name' => $setting_name,
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(VatTypeEntity::class, $response);
    }

    public function test_validation_error_on_edit_vat_type()
    {
        $vat_type_id = 1;

        Http::fake([
            'settings/vat_types'.$vat_type_id => Http::response(
                (new SettingsFakeResponse())->getSettingsFakeDetail()
            ),
        ]);

        $settings = new Settings();
        $response = $settings->vtEdit($vat_type_id, []);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $settings = new Settings();
        $response = $settings->vtEdit($vat_type_id, [
            'data' => [
                'code' => 'test',
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.name', $response->messages());
    }

    public function test_delete_vat_type()
    {
        $vat_type_id = 1;

        Http::fake([
            'settings/vat_types/' . $vat_type_id => Http::response(),
        ]);

        $settings = new Settings();
        $response = $settings->vtDelete($vat_type_id);

        $this->assertEquals('Vat type deleted', $response);
    }
}
