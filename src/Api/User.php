<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\ClientList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;

class User extends Api
{
    public function list(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ]);

        $response = $this->get(
            '/entities/user/info',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $clients = $response->data;

        return new UserList($clients);
    }

    public function detail(
        int $user_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            '/entities/user/companies',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $user = $response->data->data;

        return new UserEntity($user);
    }
}
