<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use OfflineAgency\LaravelFattureInCloudV2\Contracts\ConnectorInterface;
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloud;
use OfflineAgency\LaravelFattureInCloudV2\Traits\NormalizesDatesTrait;

class Api
{
    use NormalizesDatesTrait;

    private const MAX_RETRIES = 3;

    protected ConnectorInterface $connector;

    protected string $companyId;

    protected string $accessToken;

    public function __construct(?ConnectorInterface $connector = null)
    {
        $this->connector = $connector ?? new FattureInCloud();
        $this->companyId = $this->connector->getCompanyId();
        $this->accessToken = $this->connector->getAccessToken();
    }

    protected function get(string $url, array $queryParameters = []): object
    {
        return $this->executeWithRetry(function () use ($url, $queryParameters) {
            return $this->connector->getRequest()
                ->get($url, $queryParameters);
        });
    }

    protected function post(string $url, array $body, bool $hasFile = false): object
    {
        return $this->executeWithRetry(function () use ($url, $body, $hasFile) {
            $request = $this->connector->getRequest();

            if ($hasFile) {
                $attachment = Arr::get($body, 'attachment');
                $filename = Arr::get($body, 'filename');
                $request->attach('attachment', $attachment, $filename);
            }

            return $request->post($url, $body);
        });
    }

    protected function put(string $url, array $body): object
    {
        return $this->executeWithRetry(function () use ($url, $body) {
            return $this->connector->getRequest()
                ->put($url, $body);
        });
    }

    protected function destroy(string $url, array $queryParameters = []): object
    {
        return $this->executeWithRetry(function () use ($url, $queryParameters) {
            return $this->connector->getRequest()
                ->delete($url, $queryParameters);
        });
    }

    private function executeWithRetry(Closure $request): object
    {
        $maxRetries = (int) Config::get('fatture-in-cloud-v2.limits.max_retries', self::MAX_RETRIES);
        $attempt = 0;

        while (true) {
            $response = $request();

            if ($response->status() !== 403 && $response->status() !== 429) {
                return (object) [
                    'success' => $response->successful(),
                    'data' => $response->object(),
                ];
            }

            $attempt++;

            if ($attempt >= $maxRetries) {
                return (object) [
                    'success' => false,
                    'data' => $response->object(),
                ];
            }

            $this->waitThrottle($response->status(), $attempt);
        }
    }

    private function waitThrottle(int $status, int $attempt): void
    {
        $baseDelay = match ($status) {
            403 => (int) Config::get('fatture-in-cloud-v2.limits.403'),
            429 => (int) Config::get('fatture-in-cloud-v2.limits.429'),
            default => (int) Config::get('fatture-in-cloud-v2.limits.default'),
        };

        usleep($baseDelay * (2 ** ($attempt - 1)));
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
