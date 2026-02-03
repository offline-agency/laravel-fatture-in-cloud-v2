<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as RevenueCentersEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class InfoRevenueCentersList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($revenue_centers_response)
    {
        $this->setItems($revenue_centers_response);
    }

    /**
     * @return array<RevenueCentersEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    private function setItems(
        $revenue_centers_response
    ): void
    {
        $this->items = array_map(function ($client) {
            return new RevenueCentersEntity($client);
        }, $revenue_centers_response->data);
    }
}
