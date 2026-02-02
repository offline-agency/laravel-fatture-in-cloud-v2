<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\Product as ProductEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductList;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class Product extends Api
{
    use ListTrait;

    public function list(array $additionalData = []): ProductList|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/' . $this->companyId . '/products',
            $additionalData
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $products = $response->data;

        return new ProductList($products);
    }

    /**
     * @return array<ProductEntity>|Error
     */
    public function all(array $additionalData = []): array|Error
    {
        $allProducts = $this->getAll([
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
        ], 'c/' . $this->companyId . '/products', $additionalData);

        if ($allProducts instanceof Error) {
            return $allProducts;
        }

        return array_map(function ($product) {
            return new ProductEntity($product);
        }, $allProducts);
    }

    public function detail(int $productId, array $additionalData = []): ProductEntity|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/' . $this->companyId . '/products/' . $productId,
            $additionalData
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $product = $response->data->data;

        return new ProductEntity($product);
    }

    public function delete(int $productId): string|Error
    {
        /** @var object $response */
        $response = $this->destroy(
            'c/' . $this->companyId . '/products/' . $productId
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        return 'Product deleted';
    }

    public function create(array $body = []): ProductEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required_without_all:data.code,data.description',
            'data.code' => 'required_without_all:data.name,data.description',
            'data.description' => 'required_without_all:data.name,data.code',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->post(
            'c/' . $this->companyId . '/products',
            $body
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $product = $response->data->data;

        return new ProductEntity($product);
    }

    public function edit(int $productId, array $body = []): ProductEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required_without_all:data.code,data.description',
            'data.code' => 'required_without_all:data.name,data.description',
            'data.description' => 'required_without_all:data.name,data.code',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->put(
            'c/' . $this->companyId . '/products/' . $productId,
            $body
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $product = $response->data->data;

        return new ProductEntity($product);
    }
}
