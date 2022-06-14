<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Product;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\Product as ProductEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductPagination;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ProductFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class ProductEntityTest extends TestCase
{
    // list

    public function test_list_products()
    {
        Http::fake([
            'products' => Http::response(
                (new ProductFakeResponse())->getProductsFakeList()
            ),
        ]);

        $products = new Product();
        $response = $products->list();

        $this->assertInstanceOf(ProductList::class, $response);
        $this->assertInstanceOf(ProductPagination::class, $response->getPagination());
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(ProductEntity::class, $response->getItems()[0]);
    }

    public function test_error_on_list_products()
    {
        Http::fake([
            'products' => Http::response(
                (new ProductFakeResponse())->getProductsFakeList(),
                401
            ),
        ]);

        $products = new Product();
        $response = $products->list();

        $this->assertInstanceOf(Error::class, $response);
    }

    // pagination

    public function test_go_to_product_next_page()
    {
        $product_list = new ProductList(json_decode(
            (new ProductFakeResponse())->getProductsFakeList([
                'next_page_url' => 'https://fake_url/entity?per_page=10&page=2'
            ])
        ));

        Http::fake([
            'products?per_page=10&page=2' => Http::response(
                (new ProductFakeResponse())->getProductsFakeList()
            ),
        ]);

        $next_page_response = $product_list->getPagination()->goToNextPage();

        $this->assertInstanceOf(ProductList::class, $next_page_response);
    }

    public function test_go_to_product_prev_page()
    {
        $product_list = new ProductList(json_decode(
            (new ProductFakeResponse())->getProductsFakeList([
                'prev_page_url' => 'https://fake_url/entity?per_page=10&page=1'
            ])
        ));

        Http::fake([
            'products?per_page=10&page=1' => Http::response(
                (new ProductFakeResponse())->getProductsFakeList()
            ),
        ]);

        $prev_page_response = $product_list->getPagination()->goToPrevPage();

        $this->assertInstanceOf(ProductList::class, $prev_page_response);
    }

    public function test_go_to_product_first_page()
    {
        $product_list = new ProductList(json_decode(
            (new ProductFakeResponse())->getProductsFakeList([
                'first_page_url' => 'https://fake_url/entity?per_page=10&page=1'
            ])
        ));

        Http::fake([
            'products?per_page=10&page=1' => Http::response(
                (new ProductFakeResponse())->getProductsFakeList()
            ),
        ]);

        $first_page_response = $product_list->getPagination()->goToFirstPage();

        $this->assertInstanceOf(ProductList::class, $first_page_response);
    }

    public function test_go_to_product_last_page()
    {
        $product_list = new ProductList(json_decode(
            (new ProductFakeResponse())->getProductsFakeList([
                'last_page_url' => 'https://fake_url/entity?per_page=10&page=2'
            ])
        ));

        Http::fake([
            'products?per_page=10&page=2' => Http::response(
                (new ProductFakeResponse())->getProductsFakeList()
            ),
        ]);

        $last_page_response = $product_list->getPagination()->goToLastPage();

        $this->assertInstanceOf(ProductList::class, $last_page_response);
    }

    // single

    public function test_detail_product()
    {
        $product_id = 1;

        Http::fake([
            'products/' . $product_id => Http::response(
                (new ProductFakeResponse())->getProductsFakeDetail()
            ),
        ]);

        $product = new Product();
        $response = $product->detail($product_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ProductEntity::class, $response);
    }

    public function test_delete_product()
    {
        $product_id = 1;

        Http::fake([
            'products/' . $product_id => Http::response(),
        ]);

        $product = new Product();
        $response = $product->delete($product_id);

        $this->assertEquals('Product deleted', $response);
    }
}
