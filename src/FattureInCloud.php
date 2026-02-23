<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class FattureInCloud
{
    protected string $companyId;

    protected string $accessToken;

    protected string $baseUrl;

    public function __construct(?string $companyId = null, ?string $accessToken = null)
    {
        $this->companyId = $companyId ?? (string) Config::get('fatture-in-cloud-v2.companies.takeathome.id');
        $this->accessToken = $accessToken ?? (string) Config::get('fatture-in-cloud-v2.companies.takeathome.bearer');
        $this->baseUrl = (string) Config::get('fatture-in-cloud-v2.baseUrl', 'https://api-v2.fattureincloud.it/');
    }

    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getRequest(): PendingRequest
    {
        return Http::withToken($this->accessToken)
            ->acceptJson()
            ->baseUrl($this->baseUrl);
    }
}
