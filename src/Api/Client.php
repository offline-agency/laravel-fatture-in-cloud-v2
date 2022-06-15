<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\ClientList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;

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

    public function detail(
        int    $client_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            $this->company_id.'/entities/clients/'.$client_id,
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $client = $response->data->data;

        return new ClientEntity($client);
    }

    public function delete(
        int $client_id
    )
    {
        $response = $this->destroy(
            $this->company_id . '/entities/clients/' . $client_id
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        return 'Client deleted';
    }
}
