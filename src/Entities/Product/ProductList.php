<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Product;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\Product as ProductEntity;

class ProductList
{
    private $items;
    private $pagination;

    public function __construct($product_response)
    {
        $this->setItems($product_response);
        $this->setPagination($product_response);
    }

    /**
     * @return array<ProductEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return ProductPagination
     */
    public function getPagination(): ProductPagination
    {
        return $this->pagination;
    }

    private function setItems(
        $product_response
    ): void {
        $this->items = array_map(function ($product) {
            return new ProductEntity($product);
        }, $product_response->data);
    }

    private function setPagination(
        $product_response
    ): void {
        $this->pagination = new ProductPagination($product_response);
    }
}
