<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Info;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\PaymentAccount as PaymentAccountEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as VatEntity;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\InfoFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class InfoEntityTest extends TestCase
{
    // list

    public function test_list_vats()
    {
        Http::fake([
            'info/vat_types' => Http::response(
                (new InfoFakeResponse())->getVatTypesFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listVatTypes();

        $this->assertNotNull($response);
        $this->assertInstanceOf(InfoList::class, $response);
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(VatEntity::class, $response->getItems()[0]);
    }

    public function test_list_vat_types_has_vat_types_method()
    {
        Http::fake([
            'info/vat_types' => Http::response(
                (new InfoFakeResponse())->getVatTypesFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listVatTypes();

        $this->assertTrue($response->hasItems());
    }

    public function test_empty_list_vat_types_has_vat_types_method()
    {
        Http::fake([
            'info/vat_types' => Http::response(
                (new InfoFakeResponse())->getEmptyVatTypesFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listVatTypes();

        $this->assertFalse($response->hasItems());
    }

    public function test_error_on_list_vat_types()
    {
        Http::fake([
            'info/vat_types' => Http::response(
                (new InfoFakeResponse())->getVatTypesFakeError(),
                401
            ),
        ]);

        $info = new Info();
        $response = $info->listVatTypes();

        $this->assertInstanceOf(Error::class, $response);
    }

    public function test_list_payment_accounts()
    {
        Http::fake([
            'info/payment_accounts' => Http::response(
                (new InfoFakeResponse())->getPaymentAccountsFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listPaymentAccounts();

        $this->assertNotNull($response);
        $this->assertInstanceOf(InfoList::class, $response);
        $this->assertIsArray($response->getItems());
        $this->assertCount(1, $response->getItems());
        $this->assertInstanceOf(PaymentAccountEntity::class, $response->getItems()[0]);
    }

    public function test_list_payment_accounts_has_payment_accounts_method()
    {
        Http::fake([
            'info/payment_accounts' => Http::response(
                (new InfoFakeResponse())->getPaymentAccountsFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listPaymentAccounts();

        $this->assertTrue($response->hasItems());
    }

    public function test_empty_list_payment_accounts_has_payment_accounts_method()
    {
        Http::fake([
            'info/payment_accounts' => Http::response(
                (new InfoFakeResponse())->getEmptyPaymentAccountsFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listPaymentAccounts();

        $this->assertFalse($response->hasItems());
    }

    public function test_error_on_list_payment_accounts()
    {
        Http::fake([
            'info/payment_accounts' => Http::response(
                (new InfoFakeResponse())->getPaymentAccountsFakeError(),
                401
            ),
        ]);

        $info = new Info();
        $response = $info->listPaymentAccounts();

        $this->assertInstanceOf(Error::class, $response);
    }
}
