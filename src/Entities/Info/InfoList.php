<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

readonly class InfoList
{
    /**
     * @var array<mixed>
     */
    private array $items;

    public function __construct(object $clientResponse, string $className)
    {
        $this->items = array_map(function ($client) use ($className) {
            return new $className($client);
        }, $clientResponse->data);
    }

    /**
     * @return array<mixed>
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
