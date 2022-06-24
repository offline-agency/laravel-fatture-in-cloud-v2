<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Client;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class ClientList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($client_response)
    {
        $this->setItems($client_response);
        $this->setPagination($client_response);
    }

    /**
     * @return array<ClientEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return ClientPagination
     */
    public function getPagination(): ClientPagination
    {
        return $this->pagination;
    }

    private function setItems(
        $client_response
    ): void {
        $this->items = array_map(function ($client) {
            return new ClientEntity($client);
        }, $client_response->data);
    }

    private function setPagination(
        $client_response
    ): void {
        $this->pagination = new ClientPagination($client_response);
    }
}
