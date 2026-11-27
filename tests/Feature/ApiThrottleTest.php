<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Sleep;
use OfflineAgency\LaravelFattureInCloudV2\Api\Api;
use OfflineAgency\LaravelFattureInCloudV2\Api\Client;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ClientFakeResponse;

describe('Api throttle', function () {
    beforeEach(function () {
        Sleep::fake();
        $this->api = new Client();
    });

    it('retries on 429 using the Retry-After header (seconds)', function () {
        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 429, ['Retry-After' => '2'])
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $response = $this->api->all();

        expect($response)->toBeArray()->{0}->toBeInstanceOf(ClientEntity::class);
        Sleep::assertSequence([Sleep::for(2000)->milliseconds()]);
        Http::assertSentCount(2);
    });

    it('retries on 429 using the Retry-After header (HTTP date)', function () {
        Carbon::setTestNow('2026-01-01 10:00:00');

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 429, ['Retry-After' => 'Thu, 01 Jan 2026 10:00:05 GMT'])
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $response = $this->api->all();

        expect($response)->toBeArray();
        Sleep::assertSequence([Sleep::for(5000)->milliseconds()]);

        Carbon::setTestNow();
    });

    it('falls back to exponential backoff in milliseconds without Retry-After', function () {
        Config::set('fatture-in-cloud-v2.limits.retry_delay', 100);
        Config::set('fatture-in-cloud-v2.limits.max_retries', 3);

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 429)
                ->push([], 429)
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $response = $this->api->all();

        expect($response)->toBeArray()->{0}->toBeInstanceOf(ClientEntity::class);
        Sleep::assertSequence([
            Sleep::for(100)->milliseconds(),
            Sleep::for(200)->milliseconds(),
        ]);
    });

    it('caps the backoff at max_wait', function () {
        Config::set('fatture-in-cloud-v2.limits.retry_delay', 1000);
        Config::set('fatture-in-cloud-v2.limits.max_wait', 1500);

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 429)
                ->push([], 429)
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $this->api->all();

        Sleep::assertSequence([
            Sleep::for(1000)->milliseconds(),
            Sleep::for(1500)->milliseconds(),
        ]);
    });

    it('fails immediately when Retry-After exceeds max_wait', function () {
        Config::set('fatture-in-cloud-v2.limits.max_wait', 60000);

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push(['error' => ['message' => 'Too many requests']], 429, ['Retry-After' => '3600'])
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $response = $this->api->all();

        expect($response)->toBeInstanceOf(Error::class);
        Sleep::assertNeverSlept();
        Http::assertSentCount(1);
    });

    it('fails immediately on an absurdly large Retry-After instead of overflowing', function () {
        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 429, ['Retry-After' => '99999999999999999999'])
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        expect($this->api->all())->toBeInstanceOf(Error::class);
        Sleep::assertNeverSlept();
    });

    it('treats a past HTTP-date Retry-After as no wait', function () {
        Carbon::setTestNow('2026-01-01 10:00:00');

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 429, ['Retry-After' => 'Thu, 01 Jan 2026 09:00:00 GMT'])
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        expect($this->api->all())->toBeArray();
        Sleep::assertSequence([Sleep::for(0)->milliseconds()]);

        Carbon::setTestNow();
    });

    it('ignores a malformed Retry-After and falls back to backoff', function (string $header) {
        Config::set('fatture-in-cloud-v2.limits.retry_delay', 100);

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 429, ['Retry-After' => $header])
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        expect($this->api->all())->toBeArray();
        Sleep::assertSequence([Sleep::for(100)->milliseconds()]);
    })->with([
        'negative' => ['-5'],
        'decimal' => ['1.5'],
        'relative date' => ['+1 year'],
        'keyword' => ['now'],
        'garbage' => ['soon'],
    ]);

    it('stops after max_retries attempts on 429', function () {
        Config::set('fatture-in-cloud-v2.limits.max_retries', 3);

        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 429)
                ->push([], 429)
                ->push([], 429)
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $response = $this->api->all();

        expect($response)->toBeInstanceOf(Error::class);
        Http::assertSentCount(3);
        Sleep::assertSleptTimes(2);
    });

    it('does not retry on 403 (missing scope, expired license or exhausted quota)', function () {
        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push(['error' => ['message' => 'Quota exceeded']], 403, ['Retry-After' => '1800'])
                ->push((new ClientFakeResponse())->getClientFakeAll()),
        ]);

        $response = $this->api->all();

        expect($response)->toBeInstanceOf(Error::class);
        Sleep::assertNeverSlept();
        Http::assertSentCount(1);
    });

    it('retries POST, PUT and DELETE requests on 429', function (string $method) {
        Http::fake([
            '*/entities/clients*' => Http::sequence()
                ->push([], 429, ['Retry-After' => '1'])
                ->push(['data' => ['id' => 1, 'name' => 'Acme']]),
        ]);

        $response = match ($method) {
            'POST' => $this->api->create(['data' => ['name' => 'Acme']]),
            'PUT' => $this->api->edit(1, ['data' => ['name' => 'Acme']]),
            'DELETE' => $this->api->delete(1),
        };

        expect($response)->not->toBeInstanceOf(Error::class);
        Http::assertSentCount(2);
        Sleep::assertSleptTimes(1);
    })->with(['POST', 'PUT', 'DELETE']);
})->covers(Api::class);
