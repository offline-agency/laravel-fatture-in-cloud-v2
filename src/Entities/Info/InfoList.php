<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class InfoList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($client_response, string $className)
    {
        $this->setItems($client_response, $className);
    }

    /**
     * @return array<VatEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    private function setItems(
        $client_response,
        string $className
    ): void {
        $this->items = array_map(function ($client) use ($className) {
            return new $className($client);
        }, $client_response->data);
    }
}
