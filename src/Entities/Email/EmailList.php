<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Email;

readonly class EmailList
{
    /**
     * @var array<Email>
     */
    public array $items;

    public function __construct(\stdClass $emailResponse)
    {
        $this->items = array_map(function ($email) {
            return new Email($email);
        }, $emailResponse->data);
    }

    /**
     * @return array<Email>
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
