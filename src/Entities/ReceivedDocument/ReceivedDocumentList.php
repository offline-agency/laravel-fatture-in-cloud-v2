<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocument as ReceivedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class ReceivedDocumentList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($received_document_response)
    {
        $this->setItems($received_document_response);
        $this->setPagination($received_document_response);
    }

    /**
     * @return array<ReceivedDocumentEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return ReceivedDocumentPagination
     */
    public function getPagination(): ReceivedDocumentPagination
    {
        return $this->pagination;
    }

    private function setItems(
        $received_document_response
    ): void {
        $this->items = array_map(function ($document) {
            return new ReceivedDocumentEntity($document);
        }, $received_document_response->data);
    }

    private function setPagination(
        $received_document_response
    ): void {
        $this->pagination = new ReceivedDocumentPagination($received_document_response);
    }
}

