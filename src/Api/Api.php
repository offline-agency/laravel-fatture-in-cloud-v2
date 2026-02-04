<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloud;

class Api
{
    protected FattureInCloud $connector;

    protected string $companyId;

    protected string $accessToken;

    public function __construct(?FattureInCloud $connector = null)
    {
        $this->connector = $connector ?? new FattureInCloud();
        $this->companyId = $this->connector->getCompanyId();
        $this->accessToken = $this->connector->getAccessToken();
    }

    protected function get(string $url, array $queryParameters = []): object
    {
        $response = $this->connector->getRequest()
            ->get($url, $queryParameters);

        return $this->handleResponse($response, 'get', $url, $queryParameters);
    }

    protected function post(string $url, array $body, bool $hasFile = false): object
    {
        $request = $this->connector->getRequest();

        if ($hasFile) {
            $attachment = Arr::get($body, 'attachment');
            $filename = Arr::get($body, 'filename');
            $request->attach('attachment', $attachment, $filename);
        }

        $response = $request->post($url, $body);

        return $this->handleResponse($response, 'post', $url, $body);
    }

    protected function put(string $url, array $body): object
    {
        $response = $this->connector->getRequest()
            ->put($url, $body);

        return $this->handleResponse($response, 'put', $url, $body);
    }

    protected function destroy(string $url, array $queryParameters = []): object
    {
        $response = $this->connector->getRequest()
            ->delete($url, $queryParameters);

        return $this->handleResponse($response, 'destroy', $url, $queryParameters);
    }

    protected function handleResponse(Response $response, string $method, string $url, array $data = []): object
    {
        if ($response->status() === 403 || $response->status() === 429) {
            $this->waitThrottle($response->status());

            return $this->{$method}($url, $data);
        }

        return (object) [
            'success' => $response->successful(),
            'data' => $response->object(),
        ];
    }

    private function waitThrottle(int $status): void
    {
        $limit = match ($status) {
            403 => Config::get('fatture-in-cloud-v2.limits.403'),
            429 => Config::get('fatture-in-cloud-v2.limits.429'),
            default => Config::get('fatture-in-cloud-v2.limits.default'),
        };

        usleep((int) $limit);
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string>  $fields
     * @return array<string, mixed>
     */
    protected function data(array $data, array $fields): array
    {
        return Arr::only($data, $fields);
    }
}
