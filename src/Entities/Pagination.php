<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class Pagination
{
    use CastsFromMixed;

    public ?int $currentPage;

    public ?string $firstPageUrl;

    public ?int $from;

    public ?int $lastPage;

    public ?string $lastPageUrl;

    public ?string $nextPageUrl;

    public ?string $path;

    public ?int $perPage;

    public ?string $prevPageUrl;

    public ?int $to;

    public ?int $total;

    /**
     * @param  object|array<string, mixed>|null  $parameters
     */
    public function __construct($parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->currentPage = self::nullableInt($parameters, 'current_page');
        $this->firstPageUrl = self::nullableString($parameters, 'first_page_url');
        $this->from = self::nullableInt($parameters, 'from');
        $this->lastPage = self::nullableInt($parameters, 'last_page');
        $this->lastPageUrl = self::nullableString($parameters, 'last_page_url');
        $this->nextPageUrl = self::nullableString($parameters, 'next_page_url');
        $this->path = self::nullableString($parameters, 'path');
        $this->perPage = self::nullableInt($parameters, 'per_page');
        $this->prevPageUrl = self::nullableString($parameters, 'prev_page_url');
        $this->to = self::nullableInt($parameters, 'to');
        $this->total = self::nullableInt($parameters, 'total');
    }

    public function isSinglePage(): bool
    {
        return $this->total <= $this->perPage;
    }

    public function hasNextPage(): bool
    {
        return ! is_null($this->nextPageUrl);
    }

    public function hasPrevPage(): bool
    {
        return ! is_null($this->prevPageUrl);
    }

    /**
     * @return array<string, mixed>
     */
    public function getQueryParams(string $url): array
    {
        $query = parse_url($url, PHP_URL_QUERY);

        if (! is_string($query)) {
            return [];
        }

        parse_str($query, $params);

        $result = [];
        foreach ($params as $key => $value) {
            $result[(string) $key] = $value;
        }

        return $result;
    }
}
