<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier;

use OfflineAgency\LaravelFattureInCloudV2\Api\Supplier;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;

readonly class SupplierPagination extends Pagination
{
    public function goToFirstPage(): SupplierList|Error|null
    {
        if (is_null($this->firstPageUrl)) {
            return null;
        }

        return $this->changePage($this->firstPageUrl);
    }

    public function goToLastPage(): SupplierList|Error|null
    {
        if (is_null($this->lastPageUrl)) {
            return null;
        }

        return $this->changePage($this->lastPageUrl);
    }

    public function goToPrevPage(): SupplierList|Error|null
    {
        if (! $this->hasPrevPage()) {
            return null;
        }

        return $this->changePage($this->prevPageUrl);
    }

    public function goToNextPage(): SupplierList|Error|null
    {
        if (! $this->hasNextPage()) {
            return null;
        }

        return $this->changePage($this->nextPageUrl);
    }

    // helpers

    private function changePage(string $url): SupplierList|Error
    {
        $queryParams = $this->getQueryParams($url);

        $supplier = new Supplier();

        return $supplier->list($queryParams);
    }
}
