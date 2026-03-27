<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Traits;

use DateTimeInterface;
use Illuminate\Support\Arr;

trait NormalizesDatesTrait
{
    /**
     * Date format required by Fatture in Cloud API (OpenAPI format: date).
     */
    public const DATE_FORMAT_YMD = 'Y-m-d';

    /**
     * Normalize a value to Y-m-d string for API requests.
     * Accepts DateTimeInterface, string (Y-m-d or parseable), or null.
     *
     * @param  mixed  $value
     */
    protected function normalizeDateToYmd($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format(self::DATE_FORMAT_YMD);
        }

        if (! is_string($value)) {
            return null;
        }

        if ($this->isValidYmd($value)) {
            return $value;
        }

        $date = \DateTime::createFromFormat('Y-m-d', $value);
        if ($date !== false) {
            return $date->format(self::DATE_FORMAT_YMD);
        }

        $date = \DateTime::createFromFormat('Y-n-j', $value);
        if ($date !== false) {
            return $date->format(self::DATE_FORMAT_YMD);
        }

        try {
            $date = new \DateTime($value);

            return $date->format(self::DATE_FORMAT_YMD);
        } catch (\Exception) {
            return null;
        }
    }

    /**
     * Validate that a string is in Y-m-d (zero-padded) format.
     */
    protected function isValidYmd(string $date): bool
    {
        $d = \DateTime::createFromFormat(self::DATE_FORMAT_YMD, $date);

        return $d !== false && $d->format(self::DATE_FORMAT_YMD) === $date;
    }

    /**
     * Normalize a date field inside a nested array (e.g. body['data']['date']) to Y-m-d.
     *
     * @param  array<string, mixed>  $body
     * @return array<string, mixed>
     */
    protected function normalizeBodyDate(array $body, string $dotPath): array
    {
        $value = Arr::get($body, $dotPath);
        $normalized = $this->normalizeDateToYmd($value);
        if ($normalized !== null) {
            Arr::set($body, $dotPath, $normalized);
        }

        return $body;
    }
}
