<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class Error
{
    use CastsFromMixed;

    public mixed $error;

    /**
     * @param  object|array<string, mixed>|null  $parameters
     */
    public function __construct(
        $parameters = null
    ) {
        $parameters = self::normalizeParameters($parameters);

        $this->error = self::mixedValue($parameters, 'error');
    }
}
