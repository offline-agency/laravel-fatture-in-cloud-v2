<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\User;

use OfflineAgency\LaravelFattureInCloudV2\Entities\User\Company as CompanyEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class CompanyList
{
    use ListTrait;

    private $items;

    public function __construct($user_company_response)
    {
        $this->setItems($user_company_response);
    }

    /**
     * @return array<CompanyEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    private function setItems(
        $user_company_response
    ): void {
        $this->items = array_map(function ($company) {
            return new CompanyEntity($company);
        }, $user_company_response->companies);
    }
}
