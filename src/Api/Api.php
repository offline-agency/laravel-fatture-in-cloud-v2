<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2;

class Api extends LaravelFattureInCloudV2
{
    protected function get(
        string $url,
        array  $query_parameters = []
    ): object {
        $url = $this->baseUrl . $url;

        $response = $this->header->get($url, $query_parameters);

        return $this->parseResponse($response);
    }

    protected function data(
        array $data,
        array $fields
    ): array {
        $parsed_data = [];
        foreach ($data as $key => $value) {
            if (in_array($key, $fields)) {
                $parsed_data[$key] = $value;
            }
        }

        return $parsed_data;
    }

    private function parseResponse($response): object
    {
        return (object)[
            'success' => $response->status() === 200,
            'data' => json_decode($response),
        ];
    }
}
