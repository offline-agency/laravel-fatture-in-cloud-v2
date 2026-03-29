<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as ProductsCategoriesEntity;

readonly class InfoProductsCategoriesList
{
    /**
     * @var array<ProductsCategoriesEntity>
     */
    private array $items;

    public function __construct(object $productsCategoriesResponse)
    {
        $this->items = array_map(function ($client) {
            return new ProductsCategoriesEntity($client);
        }, $productsCategoriesResponse->data);
    }

    /**
     * @return array<ProductsCategoriesEntity>
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
