<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities;

use Illuminate\Support\Arr;

class Pagination extends AbstractEntity
{
    /**
     * @var int
     */
    public $current_page;

    /**
     * @var string
     */
    public $first_page_url;

    /**
     * @var int
     */
    public $from;

    /**
     * @var string
     */
    public $last_page;

    /**
     * @var string
     */
    public $last_page_url;

    /**
     * @var string
     */
    public $next_page_url;

    /**
     * @var string
     */
    public $path;

    /**
     * @var int
     */
    public $per_page;

    /**
     * @var string
     */
    public $prev_page_url;

    /**
     * @var int
     */
    public $to;

    /**
     * @var int
     */
    public $total;

    // methods

    public function isSinglePage(): bool
    {
        return $this->total <= $this->per_page;
    }

    public function hasNextPage(): bool
    {
        return ! is_null($this->next_page_url);
    }

    public function hasPrevPage(): bool
    {
        return ! is_null($this->prev_page_url);
    }

    // helper

    public function getQueryParams(
        string $url
    ): array {
        $url = parse_url($url);

        parse_str(
            Arr::get($url, 'query'),
            $query_params
        );

        return $query_params;
    }
}
