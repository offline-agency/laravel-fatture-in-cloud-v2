<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Company\Company as CompanyEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;

class Company extends Api
{
    public function detail(int $companyId, array $additionalData = []): CompanyEntity|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/' . $companyId . '/company/info',
            $additionalData
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $company = $response->data->data;

        return new CompanyEntity($company);
    }
}
