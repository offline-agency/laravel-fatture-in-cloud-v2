<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\User;

use OfflineAgency\LaravelFattureInCloudV2\Entities\User\Company as CompanyEntity;

readonly class CompanyList
{
    /**
     * @var array<CompanyEntity>
     */
    public array $items;

    public function __construct(object $userCompanyResponse)
    {
        $this->items = array_map(function ($company) {
            return new CompanyEntity($company);
        }, $userCompanyResponse->companies);
    }

    /**
     * @return array<CompanyEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
