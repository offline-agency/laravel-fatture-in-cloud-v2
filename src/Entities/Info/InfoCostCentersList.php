<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as CostCentersEntity;

readonly class InfoCostCentersList
{
    /**
     * @var array<CostCentersEntity>
     */
    private array $items;

    public function __construct(\stdClass $costCentersResponse)
    {
        $this->items = array_map(function ($client) {
            return new CostCentersEntity($client);
        }, $costCentersResponse->data);
    }

    /**
     * @return array<CostCentersEntity>
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
