<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier\Supplier as SupplierEntity;

readonly class SupplierList
{
    /**
     * @var array<SupplierEntity>
     */
    public array $items;

    public SupplierPagination $pagination;

    public function __construct(object $supplierResponse)
    {
        $this->items = array_map(function ($supplier) {
            return new SupplierEntity($supplier);
        }, $supplierResponse->data);

        $this->pagination = new SupplierPagination($supplierResponse);
    }

    /**
     * @return array<SupplierEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getPagination(): SupplierPagination
    {
        return $this->pagination;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
