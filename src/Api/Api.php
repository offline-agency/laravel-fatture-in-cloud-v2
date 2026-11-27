<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Closure;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Sleep;
use InvalidArgumentException;
use OfflineAgency\LaravelFattureInCloudV2\Contracts\ConnectorInterface;
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloud;
use OfflineAgency\LaravelFattureInCloudV2\Traits\NormalizesDatesTrait;
use SplFileInfo;

class Api
{
    use NormalizesDatesTrait;

    private const MAX_RETRIES = 3;

    private const DEFAULT_RETRY_DELAY_MS = 1000;

    private const DEFAULT_MAX_WAIT_MS = 60000;

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
        if (! $hasFile) {
            return $this->executeWithRetry(fn () => $this->connector->getRequest()->post($url, $body));
        }

        // Read the file once, before any attempt: Guzzle closes stream resources after
        // sending, so a 429 retry would otherwise upload an empty file.
        $contents = $this->readAttachment(Arr::get($body, 'attachment'));
        $filename = Arr::get($body, 'filename');

        // The file goes out as a multipart file part only; sending it again as a
        // plain form field would duplicate the upload.
        $fields = Arr::except($body, ['attachment']);

        return $this->executeWithRetry(fn () => $this->connector->getRequest()
            ->attach('attachment', $contents, is_string($filename) ? $filename : null)
            ->post($url, $fields));
    }

    /**
     * @throws InvalidArgumentException when the attachment is not a string, stream or readable file
     */
    private function readAttachment(mixed $attachment): string
    {
        if (is_string($attachment)) {
            return $attachment;
        }

        if (is_resource($attachment)) {
            $contents = stream_get_contents($attachment);

            if ($contents !== false) {
                return $contents;
            }
        }

        if ($attachment instanceof SplFileInfo && $attachment->isFile() && $attachment->isReadable()) {
            $contents = file_get_contents($attachment->getPathname());

            if ($contents !== false) {
                return $contents;
            }
        }

        throw new InvalidArgumentException(sprintf(
            'The attachment must be a string, a readable stream resource or a readable file (SplFileInfo / UploadedFile), %s given.',
            get_debug_type($attachment),
        ));
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

    /**
     * Send the request, retrying only on 429 (short-term rate limit).
     *
     * 403 is never retried: Fatture in Cloud uses it for missing scopes, expired
     * licenses and exhausted hourly/monthly quotas, none of which clear quickly.
     *
     * @see https://developers.fattureincloud.it/docs/basics/limits-and-quotas/
     *
     * @param  Closure(): Response  $request
     */
    private function executeWithRetry(Closure $request): ApiResponse
    {
        $maxAttempts = max(1, $this->limit('max_retries', self::MAX_RETRIES));
        $attempt = 0;

        while (true) {
            $response = $request();
            $attempt++;

            if ($response->status() !== 429 || $attempt >= $maxAttempts) {
                return $this->toApiResponse($response);
            }

            $waitMs = $this->retryDelayMs($response, $attempt);

            if ($waitMs === null) {
                return $this->toApiResponse($response);
            }

            Sleep::for($waitMs)->milliseconds();
        }
    }

    /**
     * Milliseconds to wait before the next attempt, or null when the server
     * asks for a longer wait than `limits.max_wait` allows.
     */
    private function retryDelayMs(Response $response, int $attempt): ?int
    {
        $maxWait = $this->limit('max_wait', self::DEFAULT_MAX_WAIT_MS);
        $retryAfter = $this->parseRetryAfterMs($response->header('Retry-After'));

        if ($retryAfter !== null) {
            return $retryAfter <= $maxWait ? $retryAfter : null;
        }

        $baseDelay = $this->limit('retry_delay', self::DEFAULT_RETRY_DELAY_MS);

        return min($baseDelay * (2 ** ($attempt - 1)), $maxWait);
    }

    /**
     * Parse Retry-After as delay-seconds or an IMF-fixdate (RFC 9110 §10.2.3).
     * Anything else is treated as absent, so the caller falls back to backoff.
     */
    private function parseRetryAfterMs(string $header): ?int
    {
        $header = trim($header);

        if ($header !== '' && ctype_digit($header)) {
            // Values too large to multiply safely are certainly above max_wait.
            return strlen($header) > 9 ? PHP_INT_MAX : (int) $header * 1000;
        }

        $date = DateTimeImmutable::createFromFormat(
            '!D, d M Y H:i:s \G\M\T',
            $header,
            new DateTimeZone('UTC'),
        );

        if ($date === false) {
            return null;
        }

        return max(0, ($date->getTimestamp() - Carbon::now()->getTimestamp()) * 1000);
    }

    private function limit(string $key, int $default): int
    {
        $value = Config::get('fatture-in-cloud-v2.limits.'.$key, $default);

        return is_numeric($value) ? max(0, (int) $value) : $default;
    }

    private function toApiResponse(Response $response): ApiResponse
    {
        $obj = $response->object();

        return new ApiResponse(
            success: $response->successful(),
            data: $obj instanceof \stdClass ? $obj : new \stdClass(),
        );
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
