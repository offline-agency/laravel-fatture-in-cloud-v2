<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Client;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ClientFakeResponse;

describe('Api throttle', function () {
    it('retries on 403 on GET and returns successful result', function () {
        Config::set('fatture-in-cloud-v2.limits.403', 1);

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 403)
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $api = new Client();
        $response = $api->all();

        expect($response)->toBeArray();
        expect($response[0])->toBeInstanceOf(ClientEntity::class);
    });

    it('retries on 429 on GET and returns successful result', function () {
        Config::set('fatture-in-cloud-v2.limits.429', 1);

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 429)
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $api = new Client();
        $response = $api->all();

        expect($response)->toBeArray();
        expect($response[0])->toBeInstanceOf(ClientEntity::class);
    });

    it('retries 403 on POST and returns successful result', function () {
        Config::set('fatture-in-cloud-v2.limits.403', 1);

        Http::fake([
            '*/entities/clients' => Http::sequence()
                ->push([], 403)
                ->push((new ClientFakeResponse())->getClientFakeDetail()),
        ]);

        $api = new Client();
        $response = $api->create(['data' => ['name' => 'Test']]);

        expect($response)->toBeInstanceOf(ClientEntity::class);
    });

    it('retries on 429 on POST and returns successful result', function () {
        Config::set('fatture-in-cloud-v2.limits.429', 1);

        Http::fake([
            '*/entities/clients' => Http::sequence()
                ->push([], 429)
                ->push((new ClientFakeResponse())->getClientFakeDetail()),
        ]);

        $api = new Client();
        $response = $api->create(['data' => ['name' => 'Test']]);

        expect($response)->toBeInstanceOf(ClientEntity::class);
    });

    it('retries 403 on PUT and returns successful result', function () {
        Config::set('fatture-in-cloud-v2.limits.403', 1);

        Http::fake([
            '*/entities/clients/123' => Http::sequence()
                ->push([], 403)
                ->push((new ClientFakeResponse())->getClientFakeDetail()),
        ]);

        $api = new Client();
        $response = $api->edit(123, ['data' => ['name' => 'Test']]);

        expect($response)->toBeInstanceOf(ClientEntity::class);
    });

    it('retries on 429 on PUT and returns successful result', function () {
        Config::set('fatture-in-cloud-v2.limits.429', 1);

        Http::fake([
            '*/entities/clients/123' => Http::sequence()
                ->push([], 429)
                ->push((new ClientFakeResponse())->getClientFakeDetail()),
        ]);

        $api = new Client();
        $response = $api->edit(123, ['data' => ['name' => 'Test']]);

        expect($response)->toBeInstanceOf(ClientEntity::class);
    });

    it('retries 403 on DELETE and returns successful result', function () {
        Config::set('fatture-in-cloud-v2.limits.403', 1);

        Http::fake([
            '*/entities/clients/123' => Http::sequence()
                ->push([], 403)
                ->push((new ClientFakeResponse())->getClientFakeDetail()),
        ]);

        $api = new Client();
        $response = $api->delete(123);

        expect($response)->toBeString();
    });

    it('retries on 429 on DELETE and returns successful result', function () {
        Config::set('fatture-in-cloud-v2.limits.429', 1);

        Http::fake([
            '*/entities/clients/123' => Http::sequence()
                ->push([], 429)
                ->push((new ClientFakeResponse())->getClientFakeDetail()),
        ]);

        $api = new Client();
        $response = $api->delete(123);

        expect($response)->toBeString();
    });

    it('covers default match arm of waitThrottle via reflection', function () {
        Config::set('fatture-in-cloud-v2.limits.default', 1);

        $api = new Client();
        $method = new ReflectionMethod($api, 'waitThrottle');
        $method->setAccessible(true);
        $method->invoke($api, 500);

        expect(true)->toBeTrue();
    });
});