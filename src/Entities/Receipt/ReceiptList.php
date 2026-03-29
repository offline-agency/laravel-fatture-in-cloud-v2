<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\Receipt as ReceiptEntity;

readonly class ReceiptList
{
    /**
     * @var array<ReceiptEntity>
     */
    public array $items;

    public ReceiptPagination $pagination;

    public function __construct(\stdClass $receiptResponse)
    {
        $this->items = array_map(function ($receipt) {
            return new ReceiptEntity($receipt);
        }, $receiptResponse->data);

        $this->pagination = new ReceiptPagination($receiptResponse);
    }

    /**
     * @return array<ReceiptEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getPagination(): ReceiptPagination
    {
        return $this->pagination;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
