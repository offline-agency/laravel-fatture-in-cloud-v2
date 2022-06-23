<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier\Supplier as SupplierEntity;

class SupplierList
{
    private $items;
    private $pagination;

    public function __construct($supplier_response)
    {
        $this->setItems($supplier_response);
        $this->setPagination($supplier_response);
    }

    /**
     * @return array<SupplierEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return SupplierPagination
     */
    public function getPagination(): SupplierPagination
    {
        return $this->pagination;
    }

    private function setItems(
        $supplier_response
    ): void {
        $this->items = array_map(function ($supplier) {
            return new SupplierEntity($supplier);
        }, $supplier_response->data);
    }

    private function setPagination(
        $supplier_response
    ): void {
        $this->pagination = new SupplierPagination($supplier_response);
    }
}
