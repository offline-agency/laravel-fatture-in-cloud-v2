<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Client;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ClientFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

describe('ListTrait', function () {
    it('parses query params from a URL with a query string', function () {
        $api = new Client();
        $result = $api->getQueryParams('https://api.example.com/items?page=2&per_page=50');

        expect($result)->toBe(['page' => '2', 'per_page' => '50']);
    });

    it('returns empty array for a URL without a query string', function () {
        $api = new Client();
        $result = $api->getQueryParams('https://api.example.com/items');

        expect($result)->toBe([]);
    });

    it('fetches all pages when next_page_url is present', function () {
        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push((new ClientFakeResponse())->getClientsFakeList())
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $api = new Client();
        $response = $api->all();

        expect($response)->toBeArray()->toHaveCount(4)
            ->{0}->toBeInstanceOf(ClientEntity::class);
    });
})->covers(ListTrait::class);
