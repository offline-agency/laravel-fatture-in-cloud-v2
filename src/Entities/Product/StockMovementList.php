<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Product;

readonly class StockMovementList
{
    /**
     * @var array<StockMovement>
     */
    public array $items;

    public function __construct(\stdClass $stockMovementResponse)
    {
        $this->items = array_map(function ($stockMovement) {
            return new StockMovement($stockMovement);
        }, $stockMovementResponse->data);
    }

    /**
     * @return array<StockMovement>
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
