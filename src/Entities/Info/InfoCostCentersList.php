<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as CostCentersEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class InfoCostCentersList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($cost_centers_response)
    {
        $this->setItems($cost_centers_response);
    }

    /**
     * @return array<CostCentersEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    private function setItems(
        $cost_centers_response
    ): void
    {
        $this->items = array_map(function ($client) {
            return new CostCentersEntity($client);
        }, $cost_centers_response->data);
    }
}
