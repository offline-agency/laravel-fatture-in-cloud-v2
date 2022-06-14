<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\Product as ProductEntity;

class Product extends Api
{
    public function list(
        ?array $additional_data = []
    )
    {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset', 'sort', 'page', 'per_page', 'q'
        ]);

        $response = $this->get(
            $this->company_id . '/products',
            $additional_data
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $products = $response->data;

        return new ProductList($products);
    }

    public function detail(
        int $product_id,
        ?array $additional_data = []
    )
    {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset'
        ]);

        $response = $this->get(
            $this->company_id . '/products/' . $product_id,
            $additional_data
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $products = $response->data->data;

        return new ProductEntity($products);
    }

    public function delete(
        int $product_id
    ) {
        $response = $this->destroy(
            $this->company_id.'/products/'.$product_id
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Product deleted';
    }
}
