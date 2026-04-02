<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\PriceList;

readonly class PriceListList
{
    /**
     * @var array<PriceList>
     */
    public array $items;

    public function __construct(\stdClass $priceListResponse)
    {
        $this->items = array_map(function ($priceList) {
            return new PriceList($priceList);
        }, $priceListResponse->data);
    }

    /**
     * @return array<PriceList>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
