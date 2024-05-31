<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocuments;

use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocuments\ReceivedDocument as ReceivedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class ReceivedDocumentLIst
{
    use ListTrait;

    private $items;

    private $pagination;

    public function __construct($received_documents_response)
    {
        $this->setItems($received_documents_response);
        $this->setPagination($received_documents_response);
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
    public function getPagination(): ReceivedDocumentPaginaiton
    {
        return $this->pagination;
    }

    private function setItems(
        $received_documents_response
    ): void {
        $this->items = array_map(function ($document) {
            return new ReceivedDocumentEntity($document);
        }, $received_documents_response->data);
    }

    private function setPagination(
        $received_document_response
    ): void {
        $this->pagination = new ReceivedDocumentPagination($received_document_response);
    }
}
