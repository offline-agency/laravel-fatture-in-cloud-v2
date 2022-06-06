<?php

namespace OfflineAgency\LaravelFattureInCloudV2;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class LaravelFattureInCloudV2
{
    private $bearer;
    protected $baseUrl;
    protected $header;

    /**
     * @throws Exception
     */
    public function __construct(
        ?string $company = null
    )
    {
        $this->setBearer($company);

        $this->setBaseUrl();

        $this->setHeader();
    }

    private function setBaseUrl()
    {
        $this->baseUrl = config('fatture-in-cloud-v2.baseUrl');
    }

    private function setHeader()
    {
        $this->header = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getBearer(),
        ]);
    }

    public function getBearer()
    {
        return $this->bearer;
    }

    /**
     * @throws Exception
     */
    public function setBearer($company): void
    {
        $companies = config('fatture-in-cloud-v2.companies');

        $company = is_null($company)
            ? reset($companies)
            : Arr::get($companies, $company);

        $bearer = Arr::get($company, 'bearer');

        if ($bearer === '') {
            throw new Exception('Set bearer on your config/fatture-in-cloud-v2!');
        }

        $this->bearer = $bearer;
    }
}
