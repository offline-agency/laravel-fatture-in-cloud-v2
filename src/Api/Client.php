<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\ClientList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class Client extends Api
{
    use ListTrait;

    public function list(array $additionalData = []): ClientList|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/' . $this->companyId . '/entities/clients',
            $additionalData
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $clients = $response->data;

        return new ClientList($clients);
    }

    /**
     * @return array<ClientEntity>|Error
     */
    public function all(array $additionalData = []): array|Error
    {
        $allClients = $this->getAll([
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
        ], 'c/' . $this->companyId . '/entities/clients', $additionalData);

        if ($allClients instanceof Error) {
            return $allClients;
        }

        return array_map(function ($client) {
            return new ClientEntity($client);
        }, $allClients);
    }

    public function detail(int $clientId, array $additionalData = []): ClientEntity|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/' . $this->companyId . '/entities/clients/' . $clientId,
            $additionalData
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $client = $response->data->data;

        return new ClientEntity($client);
    }

    public function delete(int $clientId): string|Error
    {
        /** @var object $response */
        $response = $this->destroy(
            'c/' . $this->companyId . '/entities/clients/' . $clientId
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        return 'Client deleted';
    }

    public function create(array $body = []): ClientEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->post(
            'c/' . $this->companyId . '/entities/clients',
            $body
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $client = $response->data->data;

        return new ClientEntity($client);
    }

    public function edit(int $clientId, array $body = []): ClientEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->put(
            'c/' . $this->companyId . '/entities/clients/' . $clientId,
            $body
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $clientResponse = $response->data->data;

        return new ClientEntity($clientResponse);
    }
}
