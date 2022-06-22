<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Client;

use OfflineAgency\LaravelFattureInCloudV2\Api\Client;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;

class ClientPagination extends Pagination
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
        if (! $this->hasPrevPage()) {
            return null;
        }

        return $this->changePage($this->prev_page_url);
    }

    public function goToNextPage()
    {
        if (! $this->hasNextPage()) {
            return null;
        }

        return $this->changePage($this->next_page_url);
    }

    // helpers

    private function changePage(
        string $url
    ) {
        $query_params = $this->getQueryParams($url);

        $client = new Client();

        return $client->list(
            $query_params
        );
    }
}
