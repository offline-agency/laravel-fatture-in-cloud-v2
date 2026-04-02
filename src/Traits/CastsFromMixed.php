<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Traits;

/**
 * Safe extraction helpers for entity constructors.
 *
 * All entity classes receive API response data as mixed/stdClass values.
 * These methods narrow `mixed` to the declared property types so that
 * PHPStan level 9 is satisfied without inline @var casts.
 */
trait CastsFromMixed
{
    /**
     * @param  array<string, mixed>  $data
     */
    protected static function nullableString(array $data, string $key): ?string
    {
        $value = $data[$key] ?? null;

        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            return $value;
        }

        if (is_int($value) || is_float($value) || is_bool($value)) {
            return (string) $value;
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function nullableInt(array $data, string $key): ?int
    {
        $value = $data[$key] ?? null;

        if ($value === null) {
            return null;
        }

        if (is_int($value)) {
            return $value;
        }

        if (is_float($value) || is_string($value) || is_bool($value)) {
            return (int) $value;
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function nullableFloat(array $data, string $key): ?float
    {
        $value = $data[$key] ?? null;

        if ($value === null) {
            return null;
        }

        if (is_float($value) || is_int($value)) {
            return (float) $value;
        }

        if (is_string($value) && is_numeric($value)) {
            return (float) $value;
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function nullableBool(array $data, string $key): ?bool
    {
        $value = $data[$key] ?? null;

        if ($value === null) {
            return null;
        }

        if (is_bool($value)) {
            return $value;
        }

        if (is_int($value) || is_string($value)) {
            return (bool) $value;
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<mixed>|null
     */
    protected static function nullableArray(array $data, string $key): ?array
    {
        $value = $data[$key] ?? null;

        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function nullableObject(array $data, string $key): ?object
    {
        $value = $data[$key] ?? null;

        if ($value === null) {
            return null;
        }

        if (is_object($value)) {
            return $value;
        }

        return null;
    }

    /**
     * Extract a raw mixed value from the data array.
     *
     * @param  array<string, mixed>  $data
     */
    protected static function mixedValue(array $data, string $key): mixed
    {
        return $data[$key] ?? null;
    }

    /**
     * Normalize constructor parameters to an associative array.
     *
     * @return array<string, mixed>
     */
    protected static function normalizeParameters(mixed $parameters): array
    {
        if (is_object($parameters)) {
            $vars = get_object_vars($parameters);

            $result = [];
            foreach ($vars as $key => $value) {
                $result[(string) $key] = $value;
            }

            return $result;
        }

        if (is_array($parameters)) {
            $result = [];
            foreach ($parameters as $key => $value) {
                $result[(string) $key] = $value;
            }

            return $result;
        }

        return [];
    }
}
