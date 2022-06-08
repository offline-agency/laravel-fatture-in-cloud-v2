<?php

namespace OfflineAgency\LaravelFattureInCloudV2;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class LaravelFattureInCloudV2
{
    private $company;
    private $bearer;
    protected $baseUrl;
    protected $header;
    protected $company_id;

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

    private function setBaseUrl()
    {
        $this->baseUrl = config('fatture-in-cloud-v2.baseUrl');
    }

    /**
     * @throws Exception
     */
    private function setCompanyId()
    {
        $company = $this->getCompany();

        $company_id = Arr::get($company, 'id');

        if ($company_id === '') {
            throw new Exception('Set company ID on your config/fatture-in-cloud-v2!');
        }

        $this->company_id = $company_id;
    }

    private function setHeader()
    {
        $this->header = Http::withHeaders([
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer '.$this->getBearer(),
        ]);
    }

    private function getBearer()
    {
        return $this->bearer;
    }

    /**
     * @throws Exception
     */
    private function setBearer(): void
    {
        $company = $this->getCompany();

        $bearer = Arr::get($company, 'bearer');

        if ($bearer === '') {
            throw new Exception('Set bearer on your config/fatture-in-cloud-v2!');
        }

        $this->bearer = $bearer;
    }

    private function getCompany()
    {
        return $this->company;
    }

    private function setCompany($company_name): void
    {
        $companies = config('fatture-in-cloud-v2.companies');

        $this->company = is_null($company_name)
            ? reset($companies)
            : Arr::get($companies, $company_name);
    }
}
