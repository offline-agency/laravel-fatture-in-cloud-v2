<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as ArchiveCategoriesEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class InfoArchiveCategoriesList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($archive_categories_response)
    {
        $this->setItems($archive_categories_response);
    }

    /**
     * @return array<ArchiveCategoriesEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    private function setItems(
        $archive_categories_response
    ): void
    {
        $this->items = array_map(function ($client) {
            return new ArchiveCategoriesEntity($client);
        }, $archive_categories_response->data);
    }
}
