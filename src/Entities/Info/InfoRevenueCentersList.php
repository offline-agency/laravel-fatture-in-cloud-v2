<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as RevenueCentersEntity;

readonly class InfoRevenueCentersList
{
    /**
     * @var array<RevenueCentersEntity>
     */
    private array $items;

    public function __construct(\stdClass $revenueCentersResponse)
    {
        $this->items = array_map(function ($client) {
            return new RevenueCentersEntity($client);
        }, $revenueCentersResponse->data);
    }

    /**
     * @return array<RevenueCentersEntity>
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
