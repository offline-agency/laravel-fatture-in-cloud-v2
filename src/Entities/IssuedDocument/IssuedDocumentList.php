<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocument as IssuedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class IssuedDocumentList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($issued_document_response)
    {
        $this->setItems($issued_document_response);
        $this->setPagination($issued_document_response);
    }

    /**
     * @return array<IssuedDocumentEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return IssuedDocumentPagination
     */
    public function getPagination(): IssuedDocumentPagination
    {
        return $this->pagination;
    }

    private function setItems(
        $issued_document_response
    ): void {
        $this->items = array_map(function ($document) {
            return new IssuedDocumentEntity($document);
        }, $issued_document_response->data);
    }

    private function setPagination(
        $issued_document_response
    ): void {
        $this->pagination = new IssuedDocumentPagination($issued_document_response);
    }
}
