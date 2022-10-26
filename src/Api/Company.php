<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Company\Company as CompanyEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;

class Company extends Api
{
    public function detail(
        int $company_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            'c/'.$company_id.'/company/info',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $company = $response->data->data;

        return new CompanyEntity($company);
    }
}
