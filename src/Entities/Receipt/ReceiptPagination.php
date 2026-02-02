<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Api\Receipt as ReceiptApi;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;

readonly class ReceiptPagination extends Pagination
{
    public function goToFirstPage(): ReceiptList|Error|null
    {
        if (is_null($this->firstPageUrl)) {
            return null;
        }

        return $this->changePage($this->firstPageUrl);
    }

    public function goToLastPage(): ReceiptList|Error|null
    {
        if (is_null($this->lastPageUrl)) {
            return null;
        }

        return $this->changePage($this->lastPageUrl);
    }

    public function goToPrevPage(): ReceiptList|Error|null
    {
        if (!$this->hasPrevPage()) {
            return null;
        }

        return $this->changePage($this->prevPageUrl);
    }

    public function goToNextPage(): ReceiptList|Error|null
    {
        if (!$this->hasNextPage()) {
            return null;
        }

        return $this->changePage($this->nextPageUrl);
    }

    // helpers

    private function changePage(string $url): ReceiptList|Error
    {
        $queryParams = $this->getQueryParams($url);

        $receipt = new ReceiptApi();

        return $receipt->list($queryParams);
    }
}
