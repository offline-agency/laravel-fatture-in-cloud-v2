<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Traits;

use Illuminate\Support\Arr;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;

trait ListTrait
{
    public function hasItems(): bool
    {
        return count($this->getItems()) > 0;
    }

    public function getQueryParams(
        string $url
    ): array {
        $url = parse_url($url);

        parse_str(
            Arr::get($url, 'query'),
            $query_params
        );

        return $query_params;
    }

    private function getAll(
        ?array  $validate_additional_data = [],
        ?string $url = null,
        ?array  $additional_data = []
    )
    {
        $additional_data = $this->data($additional_data, $validate_additional_data);

        $response = $this->get($url, $additional_data);

        if (!$response->success) {
            return new Error($response->data);
        }

        $response = $response->data;

        $this->all = gettype($this->all) == 'array'
            ? array_merge($this->all, $response->data)
            : $response->data;

        if (!isset($response->next_page_url)) {
            return $this->all;
        }

        $query_params = $this->getQueryParams($response->next_page_url);

        return $this->getAll($validate_additional_data, $url, $query_params);
    }
}
