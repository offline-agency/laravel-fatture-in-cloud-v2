<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2;

class Api extends LaravelFattureInCloudV2
{
    protected function get(
        string $url,
        array $query_parameters = []
    ): object {
        $complete_url = $this->baseUrl.$url;

        $complete_url = $this->parseUrl($complete_url);

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
        array $body,
        bool $has_file = false
    ): object {
        $complete_url = $this->baseUrl.$url;

        $complete_url = $this->parseUrl($complete_url);

        if ($has_file) {
            $response = $this->header
                ->attach('attachment', Arr::get($body, 'attachment'), Arr::get($body, 'filename'))
                ->post($complete_url, $body);
        } else {
            $response = $this->header->post($complete_url, $body);
        }

        $response_status = $response->status();

        if ($response_status === 403 || $response_status === 429) {
            $this->waitThrottle($response_status);

            $this->post($url, $body);
        }

        return $this->parseResponse($response);
    }

    protected function put(
        string $url,
        array $body
    ): object {
        $complete_url = $this->baseUrl.$url;

        $complete_url = $this->parseUrl($complete_url);

        $response = $this->header->put($complete_url, $body);

        $response_status = $response->status();

        if ($response_status === 403 || $response_status === 429) {
            $this->waitThrottle($response_status);

            $this->put($url, $body);
        }

        return $this->parseResponse($response);
    }

    protected function destroy(
        string $url,
        array $query_parameters = []
    ): object {
        $complete_url = $this->baseUrl.$url;

        $complete_url = $this->parseUrl($complete_url);

        $response = $this->header->delete($complete_url, $query_parameters);

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

    private function parseUrl(
        string $url
    ): string {
        // used to avoid breaking changes on config base url
        if (Str::contains($url, '/c/c')) {
            return str_replace('/c/c', '/c', $url);
        }

        return $url;
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
