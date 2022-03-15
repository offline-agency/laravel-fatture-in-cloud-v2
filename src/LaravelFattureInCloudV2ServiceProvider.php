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
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-fatture-in-cloud-v2');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-fatture-in-cloud-v2');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/fatture-in-cloud-v2.php' => config_path('fatture-in-cloud-v2.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-fatture-in-cloud-v2'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-fatture-in-cloud-v2'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-fatture-in-cloud-v2'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
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
