<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook;

use OfflineAgency\LaravelFattureInCloudV2\Api\Cashbook;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;

readonly class CashbookPagination extends Pagination
{
    public function goToFirstPage(): CashbookList|Error|\Illuminate\Support\MessageBag|null
    {
        if (is_null($this->firstPageUrl)) {
            return null;
        }

        return $this->changePage($this->firstPageUrl);
    }

    public function goToLastPage(): CashbookList|Error|\Illuminate\Support\MessageBag|null
    {
        if (is_null($this->lastPageUrl)) {
            return null;
        }

        return $this->changePage($this->lastPageUrl);
    }

    public function goToPrevPage(): CashbookList|Error|\Illuminate\Support\MessageBag|null
    {
        if (! $this->hasPrevPage()) {
            return null;
        }

        return $this->changePage($this->prevPageUrl);
    }

    public function goToNextPage(): CashbookList|Error|\Illuminate\Support\MessageBag|null
    {
        if (! $this->hasNextPage()) {
            return null;
        }

        return $this->changePage($this->nextPageUrl);
    }

    // helpers

    private function changePage(string $url): CashbookList|Error|\Illuminate\Support\MessageBag
    {
        $queryParams = $this->getQueryParams($url);
        if (! isset($queryParams['date_from'], $queryParams['date_to'])) {
            return new \Illuminate\Support\MessageBag([
                'date_from' => ['date_from is required (Y-m-d).'],
                'date_to' => ['date_to is required (Y-m-d).'],
            ]);
        }

        $cashbook = new Cashbook();

        return $cashbook->list($queryParams);
    }
}
