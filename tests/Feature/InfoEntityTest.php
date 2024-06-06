<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Info;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as VatEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoPaymentMethodsList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as PaymentMethodEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoPaymentAccountsList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as PaymentAccountsEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoRevenueCentersList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as RevenueCentersEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoCostCentersList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as CostCentersEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoProductsCategoriesList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as PaymentProductsCategoriesEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoReceivedDocumentCategoriesList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as ReceivedDocumentCategoriesEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoArchiveCategoriesList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as ArchiveCategoriesEntity;

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

    //Payment Methods
     public function test_list_payment_methods()
     {
         Http::fake([
             'info/payment_methods' => Http::response(
                 (new InfoFakeResponse())->getPaymentMethodsTypeFakeList()
             ),
         ]);

         $info = new Info();
         $response = $info->listPaymentMethods();

         $this->assertNotNull($response);
         $this->assertInstanceOf(InfoPaymentMethodsList::class, $response);
         $this->assertIsArray($response->getItems());
         $this->assertCount(2, $response->getItems());
         $this->assertInstanceOf(PaymentMethodEntity::class, $response->getItems()[0]);
     }

    public function test_empty_list_payment_methods_types_has_payment_methods_types_method()
    {
        Http::fake([
            'info/payment_methods' => Http::response(
                (new InfoFakeResponse())->getEmptyPaymentMethodsTypesFakeList()
            ),
        ]);

        $info = new Info();

        $response = $info->listPaymentMethods();

        $this->assertFalse($response->hasItems());
    }


    public function test_error_on_list_payment_methods_types()
    {
        Http::fake([
            'info/payment_methods' => Http::response(
                (new InfoFakeResponse())->getPaymentMethodsTypesFakeError(),
                401
            ),
        ]);

        $info = new Info();
        $response = $info->listPaymentMethods();

        $this->assertInstanceOf(Error::class, $response);
    }

    //Payment Accounts
    public function test_list_payment_accounts()
    {
        Http::fake([
            'info/payment_accounts' => Http::response(
                (new InfoFakeResponse())->getPaymentAccountsTypeFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listPaymentAccounts();

        $this->assertNotNull($response);

        $this->assertInstanceOf(InfoPaymentAccountsList::class, $response);//Problema
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(PaymentAccountsEntity::class, $response->getItems()[0]);
    }

    public function test_empty_list_payment_accounts_types_has_payment_accounts_types_method()
    {
        Http::fake([
            'info/payment_accounts' => Http::response(
                (new InfoFakeResponse())->getEmptyPaymentAccountsTypesFakeList()
            ),
        ]);

        $info = new Info();

        $response = $info->listPaymentAccounts();

        $this->assertFalse($response->hasItems());
    }

    public function test_error_on_list_payment_accounts_types()
    {
        Http::fake([
            'info/payment_accounts' => Http::response(
                (new InfoFakeResponse())->getPaymentAccountsTypesFakeError(),
                401
            ),
        ]);

        $info = new Info();
        $response = $info->listPaymentAccounts();

        $this->assertInstanceOf(Error::class, $response);
    }

    //Revenue Centers
    public function test_list_revenue_centers()
    {
        Http::fake([
            'info/revenue_centers' => Http::response(
                (new InfoFakeResponse())->getRevenueCentresTypeFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listRevenueCenters();

        $this->assertNotNull($response);
        $this->assertInstanceOf(InfoRevenueCentersList::class, $response);
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(RevenueCentersEntity::class, $response->getItems()[0]);
    }

    public function test_empty_list_revenue_centers_types_has_revenue_centre_types_method()
    {
        Http::fake([
            'info/revenue_centers' => Http::response(
                (new InfoFakeResponse())->getEmptyRevenueCentersTypesFakeList()
            ),
        ]);

        $info = new Info();

        $response = $info->listRevenueCenters();

        $this->assertFalse($response->hasItems());
    }


    public function test_error_on_list_revenue_centers_types()
    {
        Http::fake([
            'info/revenue_centers' => Http::response(
                (new InfoFakeResponse())->getRevenueCentersTypesFakeError(),
                401
            ),
        ]);

        $info = new Info();
        $response = $info->listRevenueCenters();

        $this->assertInstanceOf(Error::class, $response);
    }

    //Cost Centers
    public function test_list_cost_centers()
    {
        Http::fake([
            'info/cost_centers' => Http::response(
                (new InfoFakeResponse())->getCostCentersTypeFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listCostCenters();

        $this->assertNotNull($response);
        $this->assertInstanceOf(InfoCostCentersList::class, $response);
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(CostCentersEntity::class, $response->getItems()[0]);
    }

    public function test_empty_list_cost_centers_types_has_cost_centers_types_method()
    {
        Http::fake([
            'info/cost_centers' => Http::response(
                (new InfoFakeResponse())->getEmptyCostCentersTypesFakeList()
            ),
        ]);

        $info = new Info();

        $response = $info->listCostCenters();

        $this->assertFalse($response->hasItems());
    }

    public function test_error_on_list_cost_centers_types()
    {
        Http::fake([
            'info/cost_centers' => Http::response(
                (new InfoFakeResponse())->getCostCentersTypesFakeError(),
                401
            ),
        ]);

        $info = new Info();
        $response = $info->listCostCenters();

        $this->assertInstanceOf(Error::class, $response);
    }


    //Products Categories
    public function test_list_products_categories()
    {
        Http::fake([
            'info/product_categories' => Http::response(
                (new InfoFakeResponse())->getProductsCategoriesTypeFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listProductsCategories();

        $this->assertNotNull($response);
        $this->assertInstanceOf(InfoProductsCategoriesList::class, $response);
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(PaymentProductsCategoriesEntity::class, $response->getItems()[0]);
    }

    public function test_empty_list_products_categories_types_has_payment_methods_types_method()
    {
        Http::fake([
            'info/product_categories' => Http::response(
                (new InfoFakeResponse())->getEmptyProductsCategoriesTypesFakeList()
            ),
        ]);

        $info = new Info();

        $response = $info->listProductsCategories();

        $this->assertFalse($response->hasItems());
    }


   public function test_error_on_list_products_categories_types()
    {
        Http::fake([
            'info/payment_methods' => Http::response(
                (new InfoFakeResponse())->getProductsCategoriesTypesFakeError(),
                401
            ),
        ]);

        $info = new Info();
        $response = $info->listProductsCategories();

        $this->assertInstanceOf(Error::class, $response);
    }

    //Received Document Categories
    public function test_list_received_document_categories()
    {
        Http::fake([
            'info/received_document_categories' => Http::response(
                (new InfoFakeResponse())->getReceivedDocumentCategoriesTypeFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listReceivedDocumentCategories();

        $this->assertNotNull($response);
        $this->assertInstanceOf(InfoReceivedDocumentCategoriesList::class, $response);
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(ReceivedDocumentCategoriesEntity::class, $response->getItems()[0]);
    }

    public function test_empty_list_received_document_categories_types_has_payment_methods_types_method()
    {
        Http::fake([
            'info/received_document_categories' => Http::response(
                (new InfoFakeResponse())->getEmptyReceivedDocumentCategoriesTypesFakeList()
            ),
        ]);

        $info = new Info();

        $response = $info->listReceivedDocumentCategories();

        $this->assertFalse($response->hasItems());
    }

    public function test_error_on_list_received_document_categories_types()
    {
        Http::fake([
            'info/received_document_categories' => Http::response(
                (new InfoFakeResponse())->getReceivedDocumentCategoriesTypesFakeError(),
                401
            ),
        ]);

        $info = new Info();
        $response = $info->listReceivedDocumentCategories();

        $this->assertInstanceOf(Error::class, $response);
    }

    //Archive Categories
    public function test_list_archive_categories()
    {
        Http::fake([
            'info/archive_categories' => Http::response(
                (new InfoFakeResponse())->getArchiveCategoriesTypeFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listArchiveCategories();

        $this->assertNotNull($response);
        $this->assertInstanceOf(InfoArchiveCategoriesList::class, $response);
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(ArchiveCategoriesEntity::class, $response->getItems()[0]);
    }

    public function test_empty_list_archive_categories_types_has_payment_methods_types_method()
    {
        Http::fake([
            'info/product_categories' => Http::response(
                (new InfoFakeResponse())->getEmptyArchiveCategoriesTypesFakeList()
            ),
        ]);

        $info = new Info();

        $response = $info->listProductsCategories();

        $this->assertFalse($response->hasItems());
    }


    public function test_error_on_list_archive_categories_types()
    {
        Http::fake([
            'info/payment_methods' => Http::response(
                (new InfoFakeResponse())->getArchiveCategoriesTypesFakeError(),
                401
            ),
        ]);

        $info = new Info();
        $response = $info->listProductsCategories();

        $this->assertInstanceOf(Error::class, $response);
    }

}
