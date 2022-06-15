<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2;

class Api extends LaravelFattureInCloudV2
{
    protected function get(
        string $url,
        array $query_parameters = []
    ): object {
        $complete_url = $this->baseUrl.$url;

        $response = $this->header->get($complete_url, $query_parameters);

        $response_status = $response->status();

        if ($response_status === 403 || $response_status === 429) {
            $this->waitThrottle($response_status);

            $this->get($url, $query_parameters);
        }

        return $this->parseResponse($response);
    }

    protected function post(
        string $url,
        array $body
    ): object {
        $complete_url = $this->baseUrl.$url;

        $response = $this->header->post($complete_url, $body);

        return $this->parseResponse($response);
    }

    protected function destroy(
        string $url,
        array $query_parameters = []
    ): object {
        $url = $this->baseUrl.$url;

        $response = $this->header->delete($url, $query_parameters);

        $response_status = $response->status();

        if ($response_status === 403 || $response_status === 429) {
            $this->waitThrottle($response_status);

            $this->destroy($url, $query_parameters);
        }

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

    private function waitThrottle(
        int $status
    ) {
        switch ($status) {
            case 403:
                usleep(config('fatture-in-cloud-v2.limits.403'));
                break;
            case 429:
                usleep(config('fatture-in-cloud-v2.limits.429'));
                break;
            default:
                usleep(config('fatture-in-cloud-v2.limits.default'));
                break;
        }
    }

    private function parseResponse($response): object
    {
        return (object) [
            'success' => $response->status() === 200,
            'data' => json_decode($response),
        ];
    }
}
