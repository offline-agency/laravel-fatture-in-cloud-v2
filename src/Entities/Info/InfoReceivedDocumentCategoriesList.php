<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as ReceivedDocumentCategoriesEntity;

readonly class InfoReceivedDocumentCategoriesList
{
    /**
     * @var array<ReceivedDocumentCategoriesEntity>
     */
    private array $items;

    public function __construct(\stdClass $receivedDocumentCategoriesResponse)
    {
        $this->items = array_map(function ($client) {
            return new ReceivedDocumentCategoriesEntity($client);
        }, $receivedDocumentCategoriesResponse->data);
    }

    /**
     * @return array<ReceivedDocumentCategoriesEntity>
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
