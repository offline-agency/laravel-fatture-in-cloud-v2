<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\User\SingleCompany;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\User\SingleUser;

class UserFakeResponse extends FakeResponse
{
    public function getCompaniesFakeList(
        array $params = []
    ) {
        return json_encode([
            'data' => [
                'companies' => [
                    (new SingleCompany())->getCompanyFakeDetail($params)
                ]
            ]
        ]);
    }

    public function getUserFakeDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new SingleUser())->getUserFakeDetail($params)
        ]);
    }

    public function getUserFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }
}
