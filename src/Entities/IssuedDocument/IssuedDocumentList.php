<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocument as IssuedDocumentEntity;

readonly class IssuedDocumentList
{
    /**
     * @var array<IssuedDocumentEntity>
     */
    public array $items;

    public IssuedDocumentPagination $pagination;

    public function __construct(\stdClass $issuedDocumentResponse)
    {
        $this->items = array_map(function ($document) {
            return new IssuedDocumentEntity($document);
        }, $issuedDocumentResponse->data);

        $this->pagination = new IssuedDocumentPagination($issuedDocumentResponse);
    }

    /**
     * @return array<IssuedDocumentEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getPagination(): IssuedDocumentPagination
    {
        return $this->pagination;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
