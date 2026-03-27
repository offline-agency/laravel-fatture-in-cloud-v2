<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Company;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Company\Company as CompanyEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\CompanyFakeResponse;

describe('Company Entity', function () {
    it('gets company detail', function () {
        $companyId = 1;

        Http::fake([
            '*/company/info' => Http::response(
                (new CompanyFakeResponse())->getCompanyFakeDetail()
            ),
        ]);

        $company = new Company();
        $response = $company->detail($companyId);

        expect($response)->toBeInstanceOf(CompanyEntity::class);
    });

    it('handles error on company detail', function () {
        $companyId = 12345;

        Http::fake([
            '*/company/info' => Http::response(
                (new CompanyFakeResponse())->getCompanyFakeError(),
                401
            ),
        ]);

        $company = new Company();
        $response = $company->detail($companyId);

        expect($response)->toBeInstanceOf(Error::class);
    });
});
