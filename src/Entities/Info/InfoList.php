<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as VatEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class InfoList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($client_response)
    {
        $this->setItems($client_response);
    }

    /**
     * @return array<VatEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    private function setItems(
        $client_response
    ): void {
        $this->items = array_map(function ($client) {
            return new VatEntity($client);
        }, $client_response->data);
    }
}
