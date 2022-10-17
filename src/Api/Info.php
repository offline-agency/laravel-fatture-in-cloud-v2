<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoList;

class Info extends Api
{
    public function listVatTypes(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fieldset'
        ]);

        $response = $this->get(
            $this->company_id.'/info/vat_types',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $vats = $response->data;

        return new InfoList($vats);
    }
}
