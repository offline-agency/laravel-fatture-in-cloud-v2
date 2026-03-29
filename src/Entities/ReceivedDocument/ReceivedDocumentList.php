<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocument as ReceivedDocumentEntity;

readonly class ReceivedDocumentList
{
    /**
     * @var array<ReceivedDocumentEntity>
     */
    private array $items;

    private ReceivedDocumentPagination $pagination;

    public function __construct(\stdClass $receivedDocumentResponse)
    {
        $this->items = array_map(function ($document) {
            return new ReceivedDocumentEntity($document);
        }, $receivedDocumentResponse->data);

        $this->pagination = new ReceivedDocumentPagination($receivedDocumentResponse);
    }

    /**
     * @return array<ReceivedDocumentEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getPagination(): ReceivedDocumentPagination
    {
        return $this->pagination;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
