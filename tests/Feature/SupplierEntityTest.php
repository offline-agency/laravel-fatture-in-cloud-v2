<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Supplier;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier\Supplier as SupplierEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier\SupplierList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier\SupplierPagination;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\SupplierFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class SupplierEntityTest extends TestCase
{
    // list

    public function test_list_suppliers()
    {
        Http::fake([
            'entities/suppliers' => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeList()
            ),
        ]);

        $suppliers = new Supplier();
        $response = $suppliers->list();

        $this->assertInstanceOf(SupplierList::class, $response);
        $this->assertInstanceOf(SupplierPagination::class, $response->getPagination());
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(SupplierEntity::class, $response->getItems()[0]);
    }

    public function test_all_suppliers()
    {
        Http::fake([
            'entities/suppliers' => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeAll()
            ),
        ]);

        $suppliers = new Supplier();
        $response = $suppliers->all();

        $this->assertIsArray($response);
        $this->assertCount(2, $response);
        $this->assertInstanceOf(SupplierEntity::class, $response[0]);
    }

    public function test_error_on_all_suppliers()
    {
        Http::fake([
            'entities/suppliers' => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeError(),
                401
            ),
        ]);

        $suppliers = new Supplier();
        $response = $suppliers->all();

        $this->assertInstanceOf(Error::class, $response);
    }

    public function test_error_on_list_suppliers()
    {
        Http::fake([
            'entities/suppliers' => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeError(),
                401
            ),
        ]);

        $suppliers = new Supplier();
        $response = $suppliers->list();

        $this->assertInstanceOf(Error::class, $response);
    }

    // pagination

    public function test_go_to_supplier_next_page()
    {
        $product_list = new SupplierList(json_decode(
            (new SupplierFakeResponse())->getSupplierFakeList([
                'next_page_url' => 'https://fake_url/entities/suppliers?per_page=10&page=2',
            ])
        ));

        Http::fake([
            'entities/suppliers?per_page=10&page=2' => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeList()
            ),
        ]);

        $next_page_response = $product_list->getPagination()->goToNextPage();

        $this->assertInstanceOf(SupplierList::class, $next_page_response);
    }

    public function test_go_to_supplier_prev_page()
    {
        $product_list = new SupplierList(json_decode(
            (new SupplierFakeResponse())->getSupplierFakeList([
                'prev_page_url' => 'https://fake_url/entities/suppliers?per_page=10&page=1',
            ])
        ));

        Http::fake([
            'entities/suppliers?per_page=10&page=1' => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeList()
            ),
        ]);

        $prev_page_response = $product_list->getPagination()->goToPrevPage();

        $this->assertInstanceOf(SupplierList::class, $prev_page_response);
    }

    public function test_go_to_supplier_first_page()
    {
        $product_list = new SupplierList(json_decode(
            (new SupplierFakeResponse())->getSupplierFakeList([
                'first_page_url' => 'https://fake_url/entities/suppliers?per_page=10&page=1',
            ])
        ));

        Http::fake([
            'entities/suppliers?per_page=10&page=1' => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeList()
            ),
        ]);

        $first_page_response = $product_list->getPagination()->goToFirstPage();

        $this->assertInstanceOf(SupplierList::class, $first_page_response);
    }

    public function test_go_to_supplier_last_page()
    {
        $product_list = new SupplierList(json_decode(
            (new SupplierFakeResponse())->getSupplierFakeList([
                'last_page_url' => 'https://fake_url/entities/suppliers?per_page=10&page=2',
            ])
        ));

        Http::fake([
            'entities/suppliers?per_page=10&page=2' => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeList()
            ),
        ]);

        $last_page_response = $product_list->getPagination()->goToLastPage();

        $this->assertInstanceOf(SupplierList::class, $last_page_response);
    }

    // single

    public function test_detail_supplier()
    {
        $supplier_id = 1;

        Http::fake([
            'entities/suppliers/'.$supplier_id => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeDetail()
            ),
        ]);

        $supplier = new Supplier();
        $response = $supplier->detail($supplier_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(SupplierEntity::class, $response);
    }

    public function test_delete_supplier()
    {
        $supplier_id = 1;

        Http::fake([
            'entities/suppliers/'.$supplier_id => Http::response(),
        ]);

        $supplier = new Supplier();
        $response = $supplier->delete($supplier_id);

        $this->assertEquals('Supplier deleted', $response);
    }

    // create

    public function test_create_supplier()
    {
        Http::fake([
            'entities/suppliers' => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeDetail()
            ),
        ]);

        $supplier = new Supplier();
        $response = $supplier->create([
            'data' => [
                'name' => 'Test',
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(SupplierEntity::class, $response);
    }

    public function test_validation_error_on_create_issued_document()
    {
        $supplier = new Supplier();
        $response = $supplier->create([]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $supplier = new Supplier();
        $response = $supplier->create([
            'data' => [
                'code' => 'test',
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.name', $response->messages());
    }

    // supplier

    public function test_edit_supplier()
    {
        $supplier_id = 1;
        $supplier_name = 'Test Updated';

        Http::fake([
            'entities/suppliers/'.$supplier_id => Http::response(
                (new SupplierFakeResponse())->getSupplierFakeDetail([
                    'name' => $supplier_name,
                ])
            ),
        ]);

        $supplier = new Supplier();
        $response = $supplier->edit($supplier_id, [
            'data' => [
                'name' => $supplier_name,
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(SupplierEntity::class, $response);
    }

    public function test_validation_error_on_edit_issued_document()
    {
        $supplier_id = 1;

        $supplier = new Supplier();
        $response = $supplier->edit($supplier_id, []);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $supplier = new Supplier();
        $response = $supplier->edit($supplier_id, [
            'data' => [
                'code' => 'test',
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.name', $response->messages());
    }
}
