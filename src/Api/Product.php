<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\Product as ProductEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\StockMovement;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\StockMovementList;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

/**
 * @see https://developers.fattureincloud.it/api-reference#tag/Products
 */
class Product extends Api
{
    use ListTrait;

    /**
     * @param  array<string, mixed>  $additionalData
     */
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

        $response = $this->get(
            'c/'.$this->companyId.'/products',
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $products = $response->data;

        return new ProductList($products);
    }

    /**
     * @param  array<string, mixed>  $additionalData
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
        ], 'c/'.$this->companyId.'/products', $additionalData);

        if ($allProducts instanceof Error) {
            return $allProducts;
        }

        return array_map(function ($product) {
            return new ProductEntity($product);
        }, $allProducts);
    }

    /**
     * @param  array<string, mixed>  $additionalData
     */
    public function detail(int $productId, array $additionalData = []): ProductEntity|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
        ]);

        $response = $this->get(
            'c/'.$this->companyId.'/products/'.$productId,
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $product = $response->data->data;

        return new ProductEntity($product);
    }

    public function delete(int $productId): string|Error
    {
        $response = $this->destroy(
            'c/'.$this->companyId.'/products/'.$productId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Product deleted';
    }

    /**
     * @param  array<string, mixed>  $body
     */
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

        $response = $this->post(
            'c/'.$this->companyId.'/products',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $product = $response->data->data;

        return new ProductEntity($product);
    }

    /**
     * @param  array<string, mixed>  $body
     */
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

        $response = $this->put(
            'c/'.$this->companyId.'/products/'.$productId,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $product = $response->data->data;

        return new ProductEntity($product);
    }

    /**
     * @param  array<string, mixed>  $additionalData
     */
    public function listStockMovements(int $productId, array $additionalData = []): StockMovementList|Error
    {
        $response = $this->get(
            'c/'.$this->companyId.'/products/'.$productId.'/stock',
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $stockMovements = $response->data;

        return new StockMovementList($stockMovements);
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function createStockMovement(int $productId, array $body = []): StockMovement|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.qty' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->companyId.'/products/'.$productId.'/stock',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $stockMovement = $response->data->data;

        return new StockMovement($stockMovement);
    }

    public function deleteStockMovement(int $productId, int $stockMovementId): string|Error
    {
        $response = $this->destroy(
            'c/'.$this->companyId.'/products/'.$productId.'/stock/'.$stockMovementId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Stock movement deleted';
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function editStockMovement(int $productId, int $stockMovementId, array $body = []): StockMovement|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.qty' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            'c/'.$this->companyId.'/products/'.$productId.'/stock/'.$stockMovementId,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $stockMovement = $response->data->data;

        return new StockMovement($stockMovement);
    }
}
