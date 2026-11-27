<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Contracts\ConnectorInterface;
use OfflineAgency\LaravelFattureInCloudV2\Exceptions\ConfigurationException;

class FattureInCloud implements ConnectorInterface
{
    protected string $companyId;

    protected string $accessToken;

    protected string $baseUrl;

    /** Config key of the resolved company, or null when none was found. */
    protected ?string $companyName = null;

    /**
     * @throws ConfigurationException when $companyName is given but not configured
     */
    public function __construct(?string $companyId = null, ?string $accessToken = null, ?string $companyName = null)
    {
        // Resolution order: explicit param → named company → default company → first company in list
        $company = $this->resolveCompany($companyName);
        $rawId = Arr::get($company ?? [], 'id', '');
        $rawBearer = Arr::get($company ?? [], 'bearer', '');
        $rawBaseUrl = Config::get('fatture-in-cloud-v2.baseUrl', 'https://api-v2.fattureincloud.it/');
        $this->companyId = $companyId ?? (is_scalar($rawId) ? (string) $rawId : '');
        $this->accessToken = $accessToken ?? (is_scalar($rawBearer) ? (string) $rawBearer : '');
        $this->baseUrl = is_string($rawBaseUrl) ? $rawBaseUrl : 'https://api-v2.fattureincloud.it/';
    }

    /**
     * Resolve company config: explicit name, or default, or first in list (so project can use e.g. companies.takeathome only).
     *
     * @return array<string, mixed>|null
     *
     * @throws ConfigurationException
     */
    private function resolveCompany(?string $companyName): ?array
    {
        $rawCompanies = Config::get('fatture-in-cloud-v2.companies', []);
        $companies = is_array($rawCompanies) ? $rawCompanies : [];

        if ($companyName !== null && $companyName !== '') {
            $named = Arr::get($companies, $companyName);

            if (! is_array($named)) {
                throw ConfigurationException::unknownCompany($companyName);
            }

            $this->companyName = $companyName;

            return self::toStringKeyedArray($named);
        }

        $default = Arr::get($companies, 'default');
        if (is_array($default) && $this->isValidCompany(self::toStringKeyedArray($default))) {
            $this->companyName = 'default';

            return self::toStringKeyedArray($default);
        }

        $firstKey = array_key_first($companies);
        $first = $firstKey !== null ? $companies[$firstKey] : null;

        if (! is_array($first)) {
            return null;
        }

        $this->companyName = (string) $firstKey;

        return self::toStringKeyedArray($first);
    }

    /**
     * Convert an array with mixed keys to string-keyed array.
     *
     * @param  array<mixed, mixed>  $array
     * @return array<string, mixed>
     */
    private static function toStringKeyedArray(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $result[(string) $key] = $value;
        }

        return $result;
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

    /**
     * @throws ConfigurationException when the company ID or access token is empty
     */
    public function getRequest(): PendingRequest
    {
        if ($this->companyId === '') {
            throw ConfigurationException::missingCredential('id', $this->companyName);
        }

        if ($this->accessToken === '') {
            throw ConfigurationException::missingCredential('bearer', $this->companyName);
        }

        return Http::withToken($this->accessToken)
            ->acceptJson()
            ->baseUrl($this->baseUrl);
    }
}
