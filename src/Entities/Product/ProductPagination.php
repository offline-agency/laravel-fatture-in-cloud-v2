<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Product;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;
use OfflineAgency\LaravelFattureInCloudV2\Api\Product as ProductApi;

class ProductPagination extends Pagination
{
    public function goToFirstPage()
    {
        if (is_null($this->first_page_url)) {
            return null;
        }

        return $this->changePage($this->first_page_url);
    }

    public function goToLastPage()
    {
        if (is_null($this->last_page_url)) {
            return null;
        }

        return $this->changePage($this->last_page_url);
    }

    public function goToPrevPage()
    {
        if (!$this->hasPrevPage()) {
            return null;
        }

        return $this->changePage($this->prev_page_url);
    }

    public function goToNextPage()
    {
        if (!$this->hasNextPage()) {
            return null;
        }

        return $this->changePage($this->next_page_url);
    }

    // helpers

    private function changePage(
        string $url
    )
    {
        $query_params = $this->getQueryParams($url);

        $product = new ProductApi();

        return $product->list($query_params);
    }
}
