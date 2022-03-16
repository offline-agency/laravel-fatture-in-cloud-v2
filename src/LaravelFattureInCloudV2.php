<?php

namespace OfflineAgency\LaravelFattureInCloudV2;

use Illuminate\Support\Facades\Http;

class LaravelFattureInCloudV2
{
    protected $baseUrl;

    protected $header;

    public function __construct()
    {
        if (config('fatture-in-cloud-v2.bearer') === '') {
            throw new \Exception('Set bearer on your config/fatture-in-cloud-v2!');
        }

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
            'Authorization' => 'Bearer ' . config('fatture-in-cloud-v2.bearer')
        ]);
    }
}
