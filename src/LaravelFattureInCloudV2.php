<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

/**
 * @deprecated Use {@see FattureInCloud} instead. Will be removed in v4.0.
 */
class LaravelFattureInCloudV2
{
    /** @var array<string, mixed>|null */
    private ?array $company = null;

    private string $bearer = '';

    protected string $baseUrl = '';

    protected PendingRequest $header;

    protected string $company_id = '';

    /**
     * @throws Exception
     */
    public function __construct(
        ?string $company_name = null
    ) {
        $this->setCompany($company_name);

        $this->setBearer();

        $this->setBaseUrl();

        $this->setCompanyId();

        $this->setHeader();
    }

    private function setBaseUrl(): void
    {
        $rawUrl = config('fatture-in-cloud-v2.baseUrl');
        $this->baseUrl = is_string($rawUrl) ? $rawUrl : '';
    }

    /**
     * @throws Exception
     */
    private function setCompanyId(): void
    {
        $company = $this->getCompany();

        $company_id = Arr::get($company ?? [], 'id');

        if ($company_id === '') {
            throw new Exception('Set company ID on your config/fatture-in-cloud-v2!');
        }

        $this->company_id = is_scalar($company_id) ? (string) $company_id : '';
    }

    private function setHeader(): void
    {
        $this->header = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getBearer(),
        ]);
    }

    private function getBearer(): string
    {
        return $this->bearer;
    }

    /**
     * @throws Exception
     */
    private function setBearer(): void
    {
        $company = $this->getCompany();

        $bearer = Arr::get($company ?? [], 'bearer');

        if ($bearer === '') {
            throw new Exception('Set bearer on your config/fatture-in-cloud-v2!');
        }

        $this->bearer = is_scalar($bearer) ? (string) $bearer : '';
    }

    /**
     * @return array<string, mixed>|null
     */
    private function getCompany(): ?array
    {
        return $this->company;
    }

    private function setCompany(?string $company_name): void
    {
        $rawCompanies = config('fatture-in-cloud-v2.companies');
        $companies = is_array($rawCompanies) ? $rawCompanies : [];

        if (is_null($company_name)) {
            $first = reset($companies) ?: null;
            $this->company = is_array($first) ? self::toStringKeyedArray($first) : null;
        } else {
            $named = Arr::get($companies, $company_name);
            $this->company = is_array($named) ? self::toStringKeyedArray($named) : null;
        }
    }

    /**
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
}
