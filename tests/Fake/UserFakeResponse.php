<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\User\EmailConfirmationState;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\User\SingleCompany;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\User\SingleUser;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\User\UserInfo;

class UserFakeResponse extends FakeResponse
{
    public function getCompaniesFakeList(
        array $params = []
    ) {
        return json_encode([
            'data' => [
                'companies' => [
                    (new SingleCompany())->getCompanyFakeDetail($params),
                    (new SingleCompany())->getCompanyFakeDetail($params),
                ]
            ]
        ]);
    }

    public function getEmptyCompaniesFakeList(
        array $params = []
    ) {
        return json_encode([
            'data' => [
                'companies' => []
            ]
        ]);
    }

    public function getUserFakeDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new SingleUser())->getUserFakeDetail($params),
            'info' => (new UserInfo())->getUserInfoFakeDetail($params),
            'email_confirmation_state' => (new EmailConfirmationState())->getEmailConfirmationStateFakeDetail($params)
        ]);
    }

    public function getUserFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }
}
