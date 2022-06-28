<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Company;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Company\Company as CompanyEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\CompanyFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class CompanyEntityTest extends TestCase
{
    // detail

    public function test_detail_company()
    {
        $company_id = 1;

        Http::fake([
            'company/info' => Http::response(
                (new CompanyFakeResponse())->getCompanyFakeDetail()
            ),
        ]);

        $company = new Company();
        $response = $company->detail($company_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(CompanyEntity::class, $response);
    }

    public function test_error_detail_company()
    {
        $company_id = 664549;

        Http::fake([
            'company/info' => Http::response(
                (new CompanyFakeResponse())->getCompanyFakeError(),
                401
            ),
        ]);

        $company = new Company();
        $response = $company->detail($company_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(Error::class, $response);
    }
}
