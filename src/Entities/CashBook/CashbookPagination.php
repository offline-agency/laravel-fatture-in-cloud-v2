<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook;

use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Cashbook;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;

readonly class CashbookPagination extends Pagination
{
    public function goToFirstPage(): CashbookList|Error|MessageBag|null
    {
        if (is_null($this->firstPageUrl)) {
            return null;
        }

        return $this->changePage($this->firstPageUrl);
    }

    public function goToLastPage(): CashbookList|Error|MessageBag|null
    {
        if (is_null($this->lastPageUrl)) {
            return null;
        }

        return $this->changePage($this->lastPageUrl);
    }

    public function goToPrevPage(): CashbookList|Error|MessageBag|null
    {
        if (is_null($this->prevPageUrl)) {
            return null;
        }

        return $this->changePage($this->prevPageUrl);
    }

    public function goToNextPage(): CashbookList|Error|MessageBag|null
    {
        if (is_null($this->nextPageUrl)) {
            return null;
        }

        return $this->changePage($this->nextPageUrl);
    }

    // helpers

    private function changePage(string $url): CashbookList|Error|MessageBag
    {
        $queryParams = $this->getQueryParams($url);
        if (! isset($queryParams['date_from'], $queryParams['date_to'])) {
            return new MessageBag([
                'date_from' => ['date_from is required (Y-m-d).'],
                'date_to' => ['date_to is required (Y-m-d).'],
            ]);
        }

        $cashbook = new Cashbook();

        return $cashbook->list($queryParams);
    }
}
