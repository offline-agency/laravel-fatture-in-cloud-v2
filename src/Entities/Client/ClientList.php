<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Client;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;

readonly class ClientList
{
    /**
     * @var array<ClientEntity>
     */
    public array $items;

    public ClientPagination $pagination;

    public function __construct(\stdClass $clientResponse)
    {
        $this->items = array_map(function ($client) {
            return new ClientEntity($client);
        }, $clientResponse->data);

        $this->pagination = new ClientPagination($clientResponse);
    }

    /**
     * @return array<ClientEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getPagination(): ClientPagination
    {
        return $this->pagination;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
