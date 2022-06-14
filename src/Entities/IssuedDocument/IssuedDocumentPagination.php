<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use Illuminate\Support\Arr;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;

class IssuedDocumentPagination extends Pagination
{
    public function goToFirstPage()
    {
        if (is_null($this->first_page_url)) {
            return null;
        }

        return $this->changePage($this->first_page_url);
    }

    public function goToLastPage()
    {
        if (is_null($this->last_page_url)) {
            return null;
        }

        return $this->changePage($this->last_page_url);
    }

    public function goToPrevPage()
    {
        if (! $this->hasPrevPage()) {
            return null;
        }

        return $this->changePage($this->prev_page_url);
    }

    public function goToNextPage()
    {
        if (! $this->hasNextPage()) {
            return null;
        }

        return $this->changePage($this->next_page_url);
    }

    // helpers

    private function changePage(
        string $url
    ) {
        $query_params = $this->getParsedQueryParams($url);

        $issued_document = new IssuedDocument;

        return $issued_document->list(
            $query_params->type,
            $query_params->additional_data
        );
    }

    public function getParsedQueryParams($url): object
    {
        $query_params = $this->getQueryParams($url);

        $type = Arr::get($query_params, 'type');

        unset($query_params['type']);

        return (object) [
            'type' => $type,
            'additional_data' => $query_params,
        ];
    }
}
