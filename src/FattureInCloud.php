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
        // Resolution order: explicit param → named company → default company → first company in list
        $company = $this->resolveCompany($companyName);
        $this->companyId = $companyId ?? (string) Arr::get($company ?? [], 'id', '');
        $this->accessToken = $accessToken ?? (string) Arr::get($company ?? [], 'bearer', '');
        $this->baseUrl = (string) Config::get('fatture-in-cloud-v2.baseUrl', 'https://api-v2.fattureincloud.it/');
        // TODO: Consider throwing an InvalidArgumentException (or logging a warning) when both
        // companyId and accessToken remain empty after resolution, to surface misconfiguration early.
    }

    /**
     * Resolve company config: explicit name, or default, or first in list (so project can use e.g. companies.takeathome only).
     *
     * @return array<string, mixed>|null
     */
    private function resolveCompany(?string $companyName): ?array
    {
        /** @var array<string, array<string, mixed>> $companies */
        $companies = Config::get('fatture-in-cloud-v2.companies', []);
        if ($companyName !== null && $companyName !== '') {
            return Arr::get($companies, $companyName);
        }
        $default = Arr::get($companies, 'default');
        if (is_array($default) && $this->isValidCompany($default)) {
            return $default;
        }

        return Arr::first($companies);
    }

    /**
     * @param  array<string, mixed>  $company
     */
    private function isValidCompany(array $company): bool
    {
        return Arr::get($company, 'id') !== '' || Arr::get($company, 'bearer') !== '';
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
