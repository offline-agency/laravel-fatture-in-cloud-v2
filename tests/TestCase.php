<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Config;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2Facade;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2ServiceProvider;
use Orchestra\Testbench\Concerns\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        //Config::set('fatture-in-cloud-v2.companies.default.id', 'fake_id');
        //Config::set('fatture-in-cloud-v2.companies.default.bearer', 'fake_bearer');
        Config::set('fatture-in-cloud-v2.companies.default.id', '664549');
        Config::set('fatture-in-cloud-v2.companies.default.bearer', 'a/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyZWYiOiI4Sjk3UnpxZ3hSNzFzWnU3UWFWRHBKVlJzQTdiNE9UcyJ9.RsWTDEsYJ9AsylA7OPXknyHIO2fADtn1l0wSr7IOE_I');
    }

    public function getPackageProviders(
        $app
    ): array {
        return [
            LaravelFattureInCloudV2ServiceProvider::class,
        ];
    }

    public function getPackageAliases(
        $app
    ): array {
        return [
            'LaravelFattureInCloudV2' => LaravelFattureInCloudV2Facade::class,
        ];
    }
}
