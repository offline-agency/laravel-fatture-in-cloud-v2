<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

readonly class VatTypeList
{
    /**
     * @var array<VatType>
     */
    public array $items;

    public function __construct(\stdClass $vatTypeResponse)
    {
        $this->items = array_map(function ($vatType) {
            return new VatType($vatType);
        }, $vatTypeResponse->data);
    }

    /**
     * @return array<VatType>
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
