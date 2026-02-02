<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoList;

class Info extends Api
{
    public function listVatTypes(array $additionalData = []): InfoList|Error
    {
        $additionalData = $this->data($additionalData, [
            'fieldset',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/' . $this->companyId . '/info/vat_types',
            $additionalData
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $vats = $response->data;

        return new InfoList($vats);
    }
}
