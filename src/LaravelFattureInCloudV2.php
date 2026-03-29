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
        $this->baseUrl = (string) config('fatture-in-cloud-v2.baseUrl');
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

        $this->company_id = (string) $company_id;
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

        $this->bearer = (string) $bearer;
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
        /** @var array<string, array<string, mixed>> $companies */
        $companies = config('fatture-in-cloud-v2.companies');

        $this->company = is_null($company_name)
            ? reset($companies) ?: null
            : Arr::get($companies, $company_name);
    }
}
