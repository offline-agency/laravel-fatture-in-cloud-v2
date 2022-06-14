<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Api\Product;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\Product as ProductEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductPagination;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocumentFakeResponse;
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
        Http::fake([
            'products' => Http::response(
                (new ProductFakeResponse())->getProductsFakeList([
                    'next_page_url' => 'https://fake_url/entity?per_page=10&page=2'
                ])
            ),
        ]);

        $product = new Product();
        $response = $product->list();

        $next_page_response = $response->getPagination()->goToNextPage();

        $this->assertInstanceOf(ProductList::class, $next_page_response);
    }

    public function test_go_to_product_prev_page()
    {
        Http::fake([
            'products' => Http::response(
                (new ProductFakeResponse())->getProductsFakeList([
                    'prev_page_url' => 'https://fake_url/entity?per_page=10&page=2'
                ])
            ),
        ]);

        $product = new Product();
        $response = $product->list();

        $next_page_response = $response->getPagination()->goToPrevPage();

        $this->assertInstanceOf(ProductList::class, $next_page_response);
    }

    public function test_go_to_product_first_page()
    {
        Http::fake([
            'products' => Http::response(
                (new ProductFakeResponse())->getProductsFakeList([
                    'first_page_url' => 'https://fake_url/entity?per_page=10&page=2'
                ])
            ),
        ]);

        $product = new Product();
        $response = $product->list();

        $next_page_response = $response->getPagination()->goToFirstPage();

        $this->assertInstanceOf(ProductList::class, $next_page_response);
    }

    public function test_go_to_product_last_page()
    {
        Http::fake([
            'products' => Http::response(
                (new ProductFakeResponse())->getProductsFakeList([
                    'last_page_url' => 'https://fake_url/entity?per_page=10&page=2'
                ])
            ),
        ]);

        $product = new Product();
        $response = $product->list();

        $next_page_response = $response->getPagination()->goToLastPage();

        $this->assertInstanceOf(ProductList::class, $next_page_response);
    }

    // single
}
