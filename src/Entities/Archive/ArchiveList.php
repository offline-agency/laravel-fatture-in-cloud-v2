<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Archive;

readonly class ArchiveList
{
    /**
     * @var array<Archive>
     */
    public array $items;

    public ArchivePagination $pagination;

    public function __construct(\stdClass $archiveResponse)
    {
        $this->items = array_map(function ($archive) {
            return new Archive($archive);
        }, $archiveResponse->data);

        $this->pagination = new ArchivePagination($archiveResponse);
    }

    /**
     * @return array<Archive>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getPagination(): ArchivePagination
    {
        return $this->pagination;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
