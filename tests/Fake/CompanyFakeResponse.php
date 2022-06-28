<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Company\SingleCompany;

class CompanyFakeResponse extends FakeResponse
{
    public function getCompanyFakeDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new SingleCompany())->getCompanyFakeDetail($params),
        ]);
    }

    public function getCompanyFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }
}
