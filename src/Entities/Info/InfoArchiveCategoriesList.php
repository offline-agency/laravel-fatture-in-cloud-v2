<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as ArchiveCategoriesEntity;

readonly class InfoArchiveCategoriesList
{
    /**
     * @var array<ArchiveCategoriesEntity>
     */
    private array $items;

    public function __construct(\stdClass $archiveCategoriesResponse)
    {
        $this->items = array_map(function ($client) {
            return new ArchiveCategoriesEntity($client);
        }, $archiveCategoriesResponse->data);
    }

    /**
     * @return array<ArchiveCategoriesEntity>
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
