<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities;

readonly class Pagination
{
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
     * @param  object|array|null  $parameters
     */
    public function __construct($parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->currentPage = $parameters['current_page'] ?? null;
        $this->firstPageUrl = $parameters['first_page_url'] ?? null;
        $this->from = $parameters['from'] ?? null;
        $this->lastPage = $parameters['last_page'] ?? null;
        $this->lastPageUrl = $parameters['last_page_url'] ?? null;
        $this->nextPageUrl = $parameters['next_page_url'] ?? null;
        $this->path = $parameters['path'] ?? null;
        $this->perPage = $parameters['per_page'] ?? null;
        $this->prevPageUrl = $parameters['prev_page_url'] ?? null;
        $this->to = $parameters['to'] ?? null;
        $this->total = $parameters['total'] ?? null;
    }

    public function isSinglePage(): bool
    {
        return $this->total <= $this->perPage;
    }

    public function hasNextPage(): bool
    {
        return !is_null($this->nextPageUrl);
    }

    public function hasPrevPage(): bool
    {
        return !is_null($this->prevPageUrl);
    }

    public function getQueryParams(string $url): array
    {
        $query = parse_url($url, PHP_URL_QUERY);

        if (!$query) {
            return [];
        }

        parse_str($query, $params);

        return $params;
    }
}
