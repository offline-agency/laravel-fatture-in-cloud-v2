<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use Illuminate\Support\Arr;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;

readonly class IssuedDocumentPagination extends Pagination
{
    public function goToFirstPage(): IssuedDocumentList|Error|null
    {
        if (is_null($this->firstPageUrl)) {
            return null;
        }

        return $this->changePage($this->firstPageUrl);
    }

    public function goToLastPage(): IssuedDocumentList|Error|null
    {
        if (is_null($this->lastPageUrl)) {
            return null;
        }

        return $this->changePage($this->lastPageUrl);
    }

    public function goToPrevPage(): IssuedDocumentList|Error|null
    {
        if (!$this->hasPrevPage()) {
            return null;
        }

        return $this->changePage($this->prevPageUrl);
    }

    public function goToNextPage(): IssuedDocumentList|Error|null
    {
        if (!$this->hasNextPage()) {
            return null;
        }

        return $this->changePage($this->nextPageUrl);
    }

    // helpers

    private function changePage(string $url): IssuedDocumentList|Error
    {
        $queryParams = $this->getParsedQueryParams($url);

        $issuedDocument = new IssuedDocument();

        return $issuedDocument->list(
            $queryParams->type,
            (array) $queryParams->additional_data
        );
    }

    public function getParsedQueryParams(string $url): object
    {
        $queryParams = $this->getQueryParams($url);

        $type = Arr::get($queryParams, 'type');

        unset($queryParams['type']);

        return (object) [
            'type' => $type,
            'additional_data' => $queryParams,
        ];
    }
}
