<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info\SinglePaymentAccount;
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

    public function getPaymentAccountsFakeList(
        array $params = []
    ) {
        return json_encode([
            'data' => [
                (new SinglePaymentAccount())->getPaymentAccountFakeDetail($params)
            ]
        ]);
    }

    public function getEmptyPaymentAccountsFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ]
        ));
    }

    public function getPaymentAccountsFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }
}
