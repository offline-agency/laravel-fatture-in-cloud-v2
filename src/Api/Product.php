<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\Product as ProductEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductList;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class Product extends Api
{
    use ListTrait;

    private $all;

    public function list(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ]);

        $response = $this->get(
            $this->company_id.'/products',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $products = $response->data;

        return new ProductList($products);
    }

    public function all(
        ?array $additional_data = []
    )
    {
        $all_products = $this->getAll([
            'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ], $this->company_id.'/products', $additional_data);

        return gettype($all_products) !== 'array'
            ? $all_products
            : array_map(function ($product) {
                return new ProductEntity($product);
            }, $all_products);
    }

    public function detail(
        int $product_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            $this->company_id.'/products/'.$product_id,
            $additional_data
        );

        if (! $response->success) {
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

    public function create(
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required_without_all:data.code,data.description',
            'data.code' => 'required_without_all:data.name,data.description',
            'data.description' => 'required_without_all:data.name,data.code',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            $this->company_id.'/products',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $product = $response->data->data;

        return new ProductEntity($product);
    }

    public function edit(
        int $product_id,
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required_without_all:data.code,data.description',
            'data.code' => 'required_without_all:data.name,data.description',
            'data.description' => 'required_without_all:data.name,data.code',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            $this->company_id.'/products/'.$product_id,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $product = $response->data->data;

        return new ProductEntity($product);
    }
}
