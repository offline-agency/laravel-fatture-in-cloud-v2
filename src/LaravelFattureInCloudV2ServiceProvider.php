<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2;

use Illuminate\Support\ServiceProvider;
use OfflineAgency\LaravelFattureInCloudV2\Contracts\ConnectorInterface;
use OfflineAgency\LaravelFattureInCloudV2\Contracts\FattureInCloudManagerInterface;

class LaravelFattureInCloudV2ServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/fatture-in-cloud-v2.php' => config_path('fatture-in-cloud-v2.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/fatture-in-cloud-v2.php',
            'fatture-in-cloud-v2'
        );

        // Raw connector (direct injection still works)
        $this->app->singleton(FattureInCloud::class, fn () => new FattureInCloud());
        $this->app->alias(FattureInCloud::class, ConnectorInterface::class);

        // Manager is the facade target
        $this->app->singleton(FattureInCloudManager::class, fn ($app) => new FattureInCloudManager($app->make(FattureInCloud::class)));
        $this->app->alias(FattureInCloudManager::class, FattureInCloudManagerInterface::class);
        $this->app->alias(FattureInCloudManager::class, 'laravel-fatture-in-cloud-v2');
    }
}
