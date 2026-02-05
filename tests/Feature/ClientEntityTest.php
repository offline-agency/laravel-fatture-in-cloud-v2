<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Client;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\ClientList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\ClientPagination;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ClientFakeResponse;

describe('Client Entity', function () {
    it('lists clients', function () {
        Http::fake([
            '*/entities/clients' => Http::response(
                (new ClientFakeResponse())->getClientsFakeList()
            ),
        ]);

        $clients = new Client();
        $response = $clients->list();

        expect($response)->toBeInstanceOf(ClientList::class)
            ->getPagination()->toBeInstanceOf(ClientPagination::class)
            ->getItems()->toBeArray()->toHaveCount(2)
            ->getItems()->{0}->toBeInstanceOf(ClientEntity::class);
    });

    it('returns all clients', function () {
        Http::fake([
            '*/entities/clients' => Http::response(
                (new ClientFakeResponse())->getClientFakeAll()
            ),
        ]);

        $client = new Client();
        $response = $client->all();

        expect($response)->toBeArray()->toHaveCount(2)
            ->{0}->toBeInstanceOf(ClientEntity::class);
    });

    it('handles errors on all clients', function () {
        Http::fake([
            '*/entities/clients' => Http::response(
                (new ClientFakeResponse())->getClientFakeError(),
                401
            ),
        ]);

        $client = new Client();
        $response = $client->all();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('checks if client list has items', function () {
        Http::fake([
            '*/entities/clients' => Http::response(
                (new ClientFakeResponse())->getClientsFakeList()
            ),
        ]);

        $clients = new Client();
        $response = $clients->list();

        expect($response->hasItems())->toBeTrue();
    });

    it('checks if client list is empty', function () {
        Http::fake([
            '*/entities/clients' => Http::response(
                (new ClientFakeResponse())->getEmptyClientsFakeList()
            ),
        ]);

        $clients = new Client();
        $response = $clients->list();

        expect($response->hasItems())->toBeFalse();
    });

    it('handles error on list clients', function () {
        Http::fake([
            '*/entities/clients' => Http::response(
                (new ClientFakeResponse())->getClientFakeError(),
                401
            ),
        ]);

        $clients = new Client();
        $response = $clients->list();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('navigates to next page', function () {
        $clientList = new ClientList(json_decode(
            (new ClientFakeResponse())->getClientsFakeList([
                'next_page_url' => 'https://fake_url/entities/clients?per_page=10&page=2',
            ])
        ));

        Http::fake([
            '*/entities/clients?per_page=10&page=2' => Http::response(
                (new ClientFakeResponse())->getClientsFakeList()
            ),
        ]);

        $nextPageResponse = $clientList->getPagination()->goToNextPage();

        expect($nextPageResponse)->toBeInstanceOf(ClientList::class);
    });

    it('gets client detail', function () {
        $clientId = 1;

        Http::fake([
            '*/entities/clients/'.$clientId => Http::response(
                (new ClientFakeResponse())->getClientFakeDetail()
            ),
        ]);

        $clientView = new Client();
        $response = $clientView->detail($clientId);

        expect($response)->toBeInstanceOf(ClientEntity::class);
    });

    it('deletes a client', function () {
        $clientId = 1;

        Http::fake([
            '*/entities/clients/'.$clientId => Http::response(),
        ]);

        $client = new Client();
        $response = $client->delete($clientId);

        expect($response)->toBe('Client deleted');
    });

    it('creates a client', function () {
        Http::fake([
            '*/entities/clients' => Http::response(
                (new ClientFakeResponse())->getClientFakeDetail()
            ),
        ]);

        $client = new Client();
        $response = $client->create([
            'data' => [
                'name' => 'Test',
            ],
        ]);

        expect($response)->toBeInstanceOf(ClientEntity::class);
    });

    it('validates on creation', function () {
        $client = new Client();
        $response = $client->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('edits a client', function () {
        $clientId = 1;
        $clientName = 'Test Updated';

        Http::fake([
            '*/c/*/entities/clients/'.$clientId => Http::response(
                (new ClientFakeResponse())->getClientFakeDetail([
                    'name' => $clientName,
                ])
            ),
        ]);

        $clientApi = new Client();

        $response = $clientApi->edit($clientId, [
            'data' => [
                'name' => $clientName,
            ],
        ]);

        expect($response)->toBeInstanceOf(ClientEntity::class);
        expect($response->name)->toBe($clientName);
    });
});
