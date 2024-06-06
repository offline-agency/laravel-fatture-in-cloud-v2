<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as ReceivedDocumentCategoriesEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class InfoReceivedDocumentCategoriesList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($received_document_categories_response)
    {
        $this->setItems($received_document_categories_response);
    }

    /**
     * @return array<ReceivedDocumentCategoriesEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    private function setItems(
        $received_document_categories_response
    ): void
    {
        $this->items = array_map(function ($client) {
            return new ReceivedDocumentCategoriesEntity($client);
        }, $received_document_categories_response->data);
    }
}
