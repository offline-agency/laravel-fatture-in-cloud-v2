<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

readonly class ApiResponse
{
    public function __construct(
        public bool $success,
        public \stdClass $data,
    ) {}
}
