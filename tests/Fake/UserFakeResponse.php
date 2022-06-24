<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\User\SingleUser;

class UserFakeResponse extends FakeResponse
{
    public function getUserFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new SingleUser())->getUserFakeDetail($params),
                    (new SingleUser())->getUserFakeDetail($params),
                ],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getUserFakeDetail(
        array $params = []
    ) {
        return json_encode([
                'data' => (object) [
                    (new SingleUser())->getUserFakeDetail($params),
                ],
            ]
        );
    }

    public function getClientFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }
}
