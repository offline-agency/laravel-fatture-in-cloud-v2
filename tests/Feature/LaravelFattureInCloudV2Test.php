<?php

use Illuminate\Support\Facades\Config;
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloud;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2Facade;

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
});

describe('LaravelFattureInCloudV2Facade', function () {
    it('facade resolves to FattureInCloud instance', function () {
        expect(LaravelFattureInCloudV2Facade::getFacadeRoot())->toBeInstanceOf(FattureInCloud::class);
    });

    it('facade accessor returns correct key', function () {
        $reflection = new ReflectionClass(LaravelFattureInCloudV2Facade::class);
        $method = $reflection->getMethod('getFacadeAccessor');
        $method->setAccessible(true);

        expect($method->invoke(null))->toBe('laravel-fatture-in-cloud-v2');
    });
});
