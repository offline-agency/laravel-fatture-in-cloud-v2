<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2Facade;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2ServiceProvider;
use Orchestra\Testbench\Concerns\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function getPackageProviders(
        $app
    ): array
    {
        return [
            LaravelFattureInCloudV2ServiceProvider::class
        ];
    }

    public function getPackageAliases(
        $app
    ): array
    {
        return [
            'LaravelFattureInCloudV2' => LaravelFattureInCloudV2Facade::class,
        ];
    }
}
