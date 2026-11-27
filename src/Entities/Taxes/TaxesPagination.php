<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes;

use OfflineAgency\LaravelFattureInCloudV2\Api\Taxes;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;

readonly class TaxesPagination extends Pagination
{
    public function goToFirstPage(): TaxesList|Error|null
    {
        if (is_null($this->firstPageUrl)) {
            return null;
        }

        return $this->changePage($this->firstPageUrl);
    }

    public function goToLastPage(): TaxesList|Error|null
    {
        if (is_null($this->lastPageUrl)) {
            return null;
        }

        return $this->changePage($this->lastPageUrl);
    }

    public function goToPrevPage(): TaxesList|Error|null
    {
        if (is_null($this->prevPageUrl)) {
            return null;
        }

        return $this->changePage($this->prevPageUrl);
    }

    public function goToNextPage(): TaxesList|Error|null
    {
        if (is_null($this->nextPageUrl)) {
            return null;
        }

        return $this->changePage($this->nextPageUrl);
    }

    // helpers

    private function changePage(string $url): TaxesList|Error
    {
        $queryParams = $this->getQueryParams($url);

        $rawType = $queryParams['type'] ?? '';
        $type = is_string($rawType) ? $rawType : '';
        unset($queryParams['type']);

        $taxes = new Taxes();

        return $taxes->list($type, $queryParams);
    }
}
