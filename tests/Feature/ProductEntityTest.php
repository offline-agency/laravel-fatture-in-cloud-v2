<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use OfflineAgency\LaravelFattureInCloudV2\Api\Product;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class ProductEntityTest extends TestCase
{
    public function test_list_products()
    {
        $products = new Product();
        $response = $products->list();
    }
}
