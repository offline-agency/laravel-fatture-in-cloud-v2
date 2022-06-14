<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductList;

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
}
