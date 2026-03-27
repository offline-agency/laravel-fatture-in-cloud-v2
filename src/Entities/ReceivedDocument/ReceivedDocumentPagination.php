<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument;

use Illuminate\Support\Arr;
use OfflineAgency\LaravelFattureInCloudV2\Api\ReceivedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;

readonly class ReceivedDocumentPagination extends Pagination
{
    public function goToFirstPage(): ReceivedDocumentList|\OfflineAgency\LaravelFattureInCloudV2\Entities\Error|null
    {
        if (is_null($this->firstPageUrl)) {
            return null;
        }

        return $this->changePage($this->firstPageUrl);
    }

    public function goToLastPage(): ReceivedDocumentList|\OfflineAgency\LaravelFattureInCloudV2\Entities\Error|null
    {
        if (is_null($this->lastPageUrl)) {
            return null;
        }

        return $this->changePage($this->lastPageUrl);
    }

    public function goToPrevPage(): ReceivedDocumentList|\OfflineAgency\LaravelFattureInCloudV2\Entities\Error|null
    {
        if (! $this->hasPrevPage()) {
            return null;
        }

        return $this->changePage($this->prevPageUrl);
    }

    public function goToNextPage(): ReceivedDocumentList|\OfflineAgency\LaravelFattureInCloudV2\Entities\Error|null
    {
        if (! $this->hasNextPage()) {
            return null;
        }

        return $this->changePage($this->nextPageUrl);
    }

    // helpers

    private function changePage(string $url): ReceivedDocumentList|\OfflineAgency\LaravelFattureInCloudV2\Entities\Error
    {
        $queryParams = $this->getParsedQueryParams($url);

        $receivedDocument = new ReceivedDocument();

        return $receivedDocument->list(
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
