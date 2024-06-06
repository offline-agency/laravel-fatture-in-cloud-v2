<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\Taxes as TaxesEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class TaxesList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($taxes_response)
    {
        $this->setItems($taxes_response);
        $this->setPagination($taxes_response);
    }

    /**
     * @return array<TaxesEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return TaxesPagination
     */
    public function getPagination(): TaxesPagination
    {
        return $this->pagination;
    }

    private function setItems(
        $taxes_response
    ): void {
        $this->items = array_map(function ($document) {
            return new TaxesEntity($document);
        }, $taxes_response->data);
    }

    private function setPagination(
        $received_document_response
    ): void {
        $this->pagination = new TaxesPagination($received_document_response);
    }
}
