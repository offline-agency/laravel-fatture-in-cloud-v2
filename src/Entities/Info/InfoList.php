<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as VatEntity;

readonly class InfoList
{
    /**
     * @var array<VatEntity>
     */
    public array $items;

    public function __construct(object $clientResponse)
    {
        $this->items = array_map(function ($client) {
            return new VatEntity($client);
        }, $clientResponse->data);
    }

    /**
     * @return array<VatEntity>
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
