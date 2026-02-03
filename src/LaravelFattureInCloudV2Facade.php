<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OfflineAgency\LaravelFattureInCloudV2\FattureInCloud
 */
class LaravelFattureInCloudV2Facade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-fatture-in-cloud-v2';
    }
}
