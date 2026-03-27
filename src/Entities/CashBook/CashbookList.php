<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook;

readonly class CashbookList
{
    /**
     * @var array<CashbookEntry>
     */
    public array $items;

    public CashbookPagination $pagination;

    public function __construct(object $cashbookResponse)
    {
        $this->items = array_map(function ($cashbook) {
            return new CashbookEntry($cashbook);
        }, $cashbookResponse->data);

        $this->pagination = new CashbookPagination($cashbookResponse);
    }

    /**
     * @return array<CashbookEntry>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getPagination(): CashbookPagination
    {
        return $this->pagination;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
