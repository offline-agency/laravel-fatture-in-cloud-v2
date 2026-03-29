<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\Taxes as TaxesEntity;

readonly class TaxesList
{
    /**
     * @var array<TaxesEntity>
     */
    private array $items;

    private TaxesPagination $pagination;

    public function __construct(object $taxesResponse)
    {
        $this->items = array_map(function ($document) {
            return new TaxesEntity($document);
        }, $taxesResponse->data);

        $this->pagination = new TaxesPagination($taxesResponse);
    }

    /**
     * @return array<TaxesEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getPagination(): TaxesPagination
    {
        return $this->pagination;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
