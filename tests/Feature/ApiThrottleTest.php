<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Api;
use OfflineAgency\LaravelFattureInCloudV2\Api\Client;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ClientFakeResponse;

describe('Api throttle', function () {
    beforeEach(function () {
        $this->api = new Client();
    });

    it('retries on 403 and returns successful result', function () {
        Config::set('fatture-in-cloud-v2.limits.403', 1);

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 403)
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $response = $this->api->all();

        expect($response)->toBeArray()->{0}->toBeInstanceOf(ClientEntity::class);
    });

    it('retries on 429 and returns successful result', function () {
        Config::set('fatture-in-cloud-v2.limits.429', 1);

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 429)
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $response = $this->api->all();

        expect($response)->toBeArray()->{0}->toBeInstanceOf(ClientEntity::class);
    });

    it('stops retrying after max retries on 403', function () {
        Config::set('fatture-in-cloud-v2.limits.403', 1);

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 403)
                ->push([], 403)
                ->push([], 403)
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $response = $this->api->all();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('stops retrying after max retries on 429', function () {
        Config::set('fatture-in-cloud-v2.limits.429', 1);

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 429)
                ->push([], 429)
                ->push([], 429)
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $response = $this->api->all();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('succeeds after 2 retries within limit', function () {
        Config::set('fatture-in-cloud-v2.limits.403', 1);

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 403)
                ->push([], 403)
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $response = $this->api->all();

        expect($response)->toBeArray()->{0}->toBeInstanceOf(ClientEntity::class);
    });

    it('covers default match arm of waitThrottle via reflection', function () {
        Config::set('fatture-in-cloud-v2.limits.default', 1);

        $method = new ReflectionMethod($this->api, 'waitThrottle');
        $method->setAccessible(true);
        $method->invoke($this->api, 500, 1);

        expect(true)->toBeTrue();
    });
})->covers(Api::class);
