<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Unit;

use Mockery;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class LaravelFattureInCloudV2FacadeTest extends TestCase
{
    /**
     * @test
     */
    public function it_loads_facade_alias()
    {
        $this->app->singleton(
            'laravel-fatture-in-cloud-v2',
            function ($app) {
                return Mockery::mock(LaravelFattureInCloudV2::class, function ($mock) {
                    $mock->shouldReceive('test');
                });
            });

        \LaravelFattureInCloudV2::test();
    }
}
