<?php

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloudManager;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2Facade;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2ServiceProvider;

describe('LaravelFattureInCloudV2', function () {
    it('constructs with default company from config', function () {
        $instance = new LaravelFattureInCloudV2();

        expect($instance)->toBeInstanceOf(LaravelFattureInCloudV2::class);
    });

    it('constructs with named company from config', function () {
        $instance = new LaravelFattureInCloudV2('default');

        expect($instance)->toBeInstanceOf(LaravelFattureInCloudV2::class);
    });

    it('throws when company id is empty string', function () {
        Config::set('fatture-in-cloud-v2.companies.default.id', '');

        new LaravelFattureInCloudV2();
    })->throws(Exception::class, 'Set company ID on your config/fatture-in-cloud-v2!');

    it('throws when bearer is empty string', function () {
        Config::set('fatture-in-cloud-v2.companies.default.bearer', '');

        new LaravelFattureInCloudV2();
    })->throws(Exception::class, 'Set bearer on your config/fatture-in-cloud-v2!');
})->covers(
    LaravelFattureInCloudV2::class,
    LaravelFattureInCloudV2ServiceProvider::class,
);

describe('LaravelFattureInCloudV2Facade', function () {
    it('facade resolves to FattureInCloudManager instance', function () {
        expect(LaravelFattureInCloudV2Facade::getFacadeRoot())->toBeInstanceOf(FattureInCloudManager::class);
    });

    it('facade accessor returns correct key', function () {
        $reflection = new ReflectionClass(LaravelFattureInCloudV2Facade::class);
        $method = $reflection->getMethod('getFacadeAccessor');

        expect($method->invoke(null))->toBe('laravel-fatture-in-cloud-v2');
    });

    it('keeps the 3.0 connector methods available on the facade', function () {
        // In 3.0.x the facade resolved to the FattureInCloud connector.
        expect(LaravelFattureInCloudV2Facade::getCompanyId())->toBe('fake_id')
            ->and(LaravelFattureInCloudV2Facade::getAccessToken())->toBe('fake_bearer')
            ->and(LaravelFattureInCloudV2Facade::getBaseUrl())->toBe('https://api-v2.fattureincloud.it/')
            ->and(LaravelFattureInCloudV2Facade::getRequest())->toBeInstanceOf(PendingRequest::class);
    });

    it('delegates connector methods to the switched company', function () {
        Config::set('fatture-in-cloud-v2.companies.acme', ['id' => 'acme_id', 'bearer' => 'acme_bearer']);

        expect(LaravelFattureInCloudV2Facade::forCompany('acme')->getCompanyId())->toBe('acme_id');
    });
})->covers(LaravelFattureInCloudV2Facade::class, FattureInCloudManager::class);
