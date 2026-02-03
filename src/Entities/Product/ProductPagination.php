<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Product;

use OfflineAgency\LaravelFattureInCloudV2\Api\Product as ProductApi;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;

readonly class ProductPagination extends Pagination
{
    public function goToFirstPage(): ProductList|Error|null
    {
        if (is_null($this->firstPageUrl)) {
            return null;
        }

        return $this->changePage($this->firstPageUrl);
    }

    public function goToLastPage(): ProductList|Error|null
    {
        if (is_null($this->lastPageUrl)) {
            return null;
        }

        return $this->changePage($this->lastPageUrl);
    }

    public function goToPrevPage(): ProductList|Error|null
    {
        if (!$this->hasPrevPage()) {
            return null;
        }

        return $this->changePage($this->prevPageUrl);
    }

    public function goToNextPage(): ProductList|Error|null
    {
        if (!$this->hasNextPage()) {
            return null;
        }

        return $this->changePage($this->nextPageUrl);
    }

    // helpers

    private function changePage(string $url): ProductList|Error
    {
        $queryParams = $this->getQueryParams($url);

        $product = new ProductApi();

        return $product->list($queryParams);
    }
}
