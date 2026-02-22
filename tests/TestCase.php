<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests;

use Illuminate\Support\Facades\Config;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2Facade;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('fatture-in-cloud-v2.companies.default.id', 'fake_id');
        Config::set('fatture-in-cloud-v2.companies.default.bearer', 'fake_bearer');
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
