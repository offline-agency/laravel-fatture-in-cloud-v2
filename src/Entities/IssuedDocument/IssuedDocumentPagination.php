<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use Illuminate\Support\Arr;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;

class IssuedDocumentPagination extends Pagination
{
    public function goToFirstPage(): ?IssuedDocumentList
    {
        if (is_null($this->first_page_url)) {
            return null;
        }

        $query_params = $this->getParsedQueryParams($this->first_page_url);

        $issued_document = new IssuedDocument;

        return $issued_document->list(
            $query_params->type,
            $query_params->additional_data
        );
    }

    // helpers

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
