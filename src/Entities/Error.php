<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities;

readonly class Error
{
    public mixed $error;

    /**
     * @param  object|array|null  $parameters
     */
    public function __construct(
        $parameters = null
    ) {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->error = $parameters['error'] ?? null;
    }
}
