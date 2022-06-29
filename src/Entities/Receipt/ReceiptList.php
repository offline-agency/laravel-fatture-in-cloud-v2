<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\Receipt as ReceiptEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class ReceiptList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($product_response)
    {
        $this->setItems($product_response);
        $this->setPagination($product_response);
    }

    /**
     * @return array<ReceiptEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return ReceiptPagination
     */
    public function getPagination(): ReceiptPagination
    {
        return $this->pagination;
    }

    private function setItems(
        $product_response
    ): void {
        $this->items = array_map(function ($product) {
            return new ReceiptEntity($product);
        }, $product_response->data);
    }

    private function setPagination(
        $product_response
    ): void {
        $this->pagination = new ReceiptPagination($product_response);
    }
}
