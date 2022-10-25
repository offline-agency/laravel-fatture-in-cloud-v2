<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info\SingleVat;

class InfoFakeResponse extends FakeResponse
{
    public function getVatTypesFakeList(
        array $params = []
    ) {
        return json_encode([
            'data' => [
                (new SingleVat())->getVatTypeFakeDetail($params),
                (new SingleVat())->getVatTypeFakeDetail($params),
            ],
        ]
        );
    }

    public function getEmptyVatTypesFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ]
        ));
    }

    public function getVatTypesFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }
}
