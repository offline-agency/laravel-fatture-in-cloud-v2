<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\ClientList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class Client extends Api
{
    use ListTrait;

    public function list(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ]);

        $response = $this->get(
            'c/'.$this->company_id.'/entities/clients',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $clients = $response->data;

        return new ClientList($clients);
    }

    public function all(
        ?array $additional_data = []
    ) {
        $all_clients = $this->getAll([
            'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ], $this->company_id.'/entities/clients', $additional_data);

        return gettype($all_clients) !== 'array'
            ? $all_clients
            : array_map(function ($client) {
                return new ClientEntity($client);
            }, $all_clients);
    }

    public function detail(
        int $client_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            'c/'.$this->company_id.'/entities/clients/'.$client_id,
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
    ) {
        $response = $this->destroy(
            'c/'.$this->company_id.'/entities/clients/'.$client_id
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Client deleted';
    }

    public function create(
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->company_id.'/entities/clients',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $client = $response->data->data;

        return new ClientEntity($client);
    }

    public function edit(
        int $client_id,
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            'c/'.$this->company_id.'/entities/clients/'.$client_id,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $client_id = $response->data->data;

        return new ClientEntity($client_id);
    }
}
