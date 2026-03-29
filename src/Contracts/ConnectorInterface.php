<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Contracts;

use Illuminate\Http\Client\PendingRequest;

interface ConnectorInterface
{
    public function getCompanyId(): string;

    public function getAccessToken(): string;

    public function getBaseUrl(): string;

    public function getRequest(): PendingRequest;
}
