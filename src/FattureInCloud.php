<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class FattureInCloud
{
    protected string $companyId;

    protected string $accessToken;

    protected string $baseUrl;

    public function __construct(?string $companyId = null, ?string $accessToken = null, ?string $companyName = null)
    {
        $company = $this->resolveCompany($companyName);
        $this->companyId = $companyId ?? (string) Arr::get($company ?? [], 'id', '');
        $this->accessToken = $accessToken ?? (string) Arr::get($company ?? [], 'bearer', '');
        $this->baseUrl = (string) Config::get('fatture-in-cloud-v2.baseUrl', 'https://api-v2.fattureincloud.it/');
    }

    /**
     * Resolve company config: explicit name, or default, or first in list (so project can use e.g. companies.takeathome only).
     *
     * @return array<string, mixed>|null
     */
    private function resolveCompany(?string $companyName): ?array
    {
        $companies = Config::get('fatture-in-cloud-v2.companies', []);
        if ($companyName !== null && $companyName !== '') {
            return Arr::get($companies, $companyName);
        }
        $default = Arr::get($companies, 'default');
        if (is_array($default) && (Arr::get($default, 'id') !== '' || Arr::get($default, 'bearer') !== '')) {
            return $default;
        }
        $first = reset($companies);

        return $first !== false ? $first : null;
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
