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

    /**
     * @param  array<string, mixed>  $queryParameters
     */
    protected function get(string $url, array $queryParameters = []): ApiResponse
    {
        return $this->executeWithRetry(function () use ($url, $queryParameters) {
            return $this->connector->getRequest()
                ->get($url, $queryParameters);
        });
    }

    /**
     * @param  array<string, mixed>  $body
     */
    protected function post(string $url, array $body, bool $hasFile = false): ApiResponse
    {
        return $this->executeWithRetry(function () use ($url, $body, $hasFile) {
            $request = $this->connector->getRequest();

            if ($hasFile) {
                $attachment = Arr::get($body, 'attachment');
                $filename = Arr::get($body, 'filename');
                $request->attach(
                    'attachment',
                    is_string($attachment) ? $attachment : '',
                    is_string($filename) ? $filename : null,
                );
            }

            return $request->post($url, $body);
        });
    }

    /**
     * @param  array<string, mixed>  $body
     */
    protected function put(string $url, array $body): ApiResponse
    {
        return $this->executeWithRetry(function () use ($url, $body) {
            return $this->connector->getRequest()
                ->put($url, $body);
        });
    }

    /**
     * @param  array<string, mixed>  $queryParameters
     */
    protected function destroy(string $url, array $queryParameters = []): ApiResponse
    {
        return $this->executeWithRetry(function () use ($url, $queryParameters) {
            return $this->connector->getRequest()
                ->delete($url, $queryParameters);
        });
    }

    private function executeWithRetry(Closure $request): ApiResponse
    {
        $configRetries = Config::get('fatture-in-cloud-v2.limits.max_retries', self::MAX_RETRIES);
        $maxRetries = is_numeric($configRetries) ? (int) $configRetries : self::MAX_RETRIES;
        $attempt = 0;

        while (true) {
            $response = $request();

            if ($response->status() !== 403 && $response->status() !== 429) {
                $obj = $response->object();

                return new ApiResponse(
                    success: $response->successful(),
                    data: $obj instanceof \stdClass ? $obj : new \stdClass(),
                );
            }

            $attempt++;

            if ($attempt >= $maxRetries) {
                $obj = $response->object();

                return new ApiResponse(
                    success: false,
                    data: $obj instanceof \stdClass ? $obj : new \stdClass(),
                );
            }

            $this->waitThrottle($response->status(), $attempt);
        }
    }

    private function waitThrottle(int $status, int $attempt): void
    {
        $configDelay = match ($status) {
            403 => Config::get('fatture-in-cloud-v2.limits.403'),
            429 => Config::get('fatture-in-cloud-v2.limits.429'),
            default => Config::get('fatture-in-cloud-v2.limits.default'),
        };
        $baseDelay = is_numeric($configDelay) ? (int) $configDelay : 0;

        usleep($baseDelay * (2 ** ($attempt - 1)));
    }

    /**
     * @param  array<int|string, mixed>  $data
     * @param  array<string>  $fields
     * @return array<string, mixed>
     */
    protected function data(array $data, array $fields): array
    {
        return Arr::only($data, $fields);
    }
}
