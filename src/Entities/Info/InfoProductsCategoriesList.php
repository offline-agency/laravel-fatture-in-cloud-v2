<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as ProductsCategoriesEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class InfoProductsCategoriesList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($products_categories_response)
    {
        $this->setItems($products_categories_response);
    }

    /**
     * @return array<ProductsCategoriesEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    private function setItems(
        $products_categories_response
    ): void
    {
        $this->items = array_map(function ($client) {
            return new ProductsCategoriesEntity($client);
        }, $products_categories_response->data);
    }
}
