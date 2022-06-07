<?php

namespace OfflineAgency\LaravelFattureInCloudV2;

use Illuminate\Support\ServiceProvider;

class LaravelFattureInCloudV2ServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
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
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(
            __DIR__.'/../config/fatture-in-cloud-v2.php',
            'fatture-in-cloud-v2'
        );

        // Register the main class to use with the facade
        $this->app->singleton('laravel-fatture-in-cloud-v2', function () {
            return new LaravelFattureInCloudV2();
        });
    }
}
