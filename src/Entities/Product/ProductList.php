<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Product;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\Product as ProductEntity;

readonly class ProductList
{
    /**
     * @var array<ProductEntity>
     */
    public array $items;

    public ProductPagination $pagination;

    public function __construct(\stdClass $productResponse)
    {
        $this->items = array_map(function ($product) {
            return new ProductEntity($product);
        }, $productResponse->data);

        $this->pagination = new ProductPagination($productResponse);
    }

    /**
     * @return array<ProductEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getPagination(): ProductPagination
    {
        return $this->pagination;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
