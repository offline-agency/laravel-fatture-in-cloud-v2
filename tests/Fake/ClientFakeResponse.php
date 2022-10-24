<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Client\SingleClient;

class ClientFakeResponse extends FakeResponse
{
    public function getClientsFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new SingleClient())->getClientFakeDetail($params),
                    (new SingleClient())->getClientFakeDetail($params),
                ],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getClientFakeAll(
        array $params = []
    )
    {
        return json_encode(array_merge(
            [
                'data' => [
                    (new SingleClient())->getClientFakeDetail($params),
                    (new SingleClient())->getClientFakeDetail($params),
                ],
            ]
        ));
    }

    public function getEmptyClientsFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getClientFakeDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (object) [
                (new SingleClient())->getClientFakeDetail($params),
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
