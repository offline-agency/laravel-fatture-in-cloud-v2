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
        if (is_null($this->prevPageUrl)) {
            return null;
        }

        return $this->changePage($this->prevPageUrl);
    }

    public function goToNextPage(): IssuedDocumentList|Error|null
    {
        if (is_null($this->nextPageUrl)) {
            return null;
        }

        return $this->changePage($this->nextPageUrl);
    }

    // helpers

    private function changePage(string $url): IssuedDocumentList|Error
    {
        $queryParams = $this->getQueryParams($url);

        $type = Arr::get($queryParams, 'type', '');
        unset($queryParams['type']);

        $issuedDocument = new IssuedDocument();

        return $issuedDocument->list(
            is_string($type) ? $type : '',
            $queryParams
        );
    }

    /**
     * @return \stdClass&object{type: mixed, additional_data: array<int|string, mixed>}
     */
    public function getParsedQueryParams(string $url): \stdClass
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
