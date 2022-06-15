<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\ClientList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;

class Client extends Api
{
    public function list(
        ?array $additional_data = []
    )
    {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ]);

        $response = $this->get(
            $this->company_id.'/entities/clients',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $clients = $response->data;

        return new ClientList($clients);
    }
}
