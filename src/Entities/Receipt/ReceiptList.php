<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\Receipt as ReceiptEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class ReceiptList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($receipt_response)
    {
        $this->setItems($receipt_response);
        $this->setPagination($receipt_response);
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
        $receipt_response
    ): void {
        $this->items = array_map(function ($receipt) {
            return new ReceiptEntity($receipt);
        }, $receipt_response->data);
    }

    private function setPagination(
        $receipt_response
    ): void {
        $this->pagination = new ReceiptPagination($receipt_response);
    }
}
