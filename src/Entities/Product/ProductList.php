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
        $issued_document_response
    ): void {
        $this->items = array_map(function ($document) {
            return new ProductEntity($document);
        }, $issued_document_response->data);
    }

    private function setPagination(
        $issued_document_response
    ): void {
        $this->pagination = new ProductPagination($issued_document_response);
    }
}
