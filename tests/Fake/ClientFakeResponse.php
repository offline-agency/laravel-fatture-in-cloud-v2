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
}
