<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Company;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Company\Company as CompanyEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\CompanyFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class CompanyEntityTest extends TestCase
{
    // single

    public function test_detail_company()
    {
        $company_id = 1;

        Http::fake([
            '/c/'.$company_id.'company/info/' => Http::response(
                (new CompanyFakeResponse())->getCompanyFakeDetail()
            ),
        ]);

        $company = new Company();
        $response = $company->detail($company_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(CompanyEntity::class, $response);
    }
}
