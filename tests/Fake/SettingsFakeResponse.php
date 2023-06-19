<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Settings\SinglePaymentMethod;

class SettingsFakeResponse extends FakeResponse
{
    public function getSettingsFakeDetail(
        array $params = []
    ) {
        return json_encode([
                'data' => (object) [
                    (new SinglePaymentMethod())->getPaymentMethodFakeDetail($params),
                ],
            ]
        );
    }
}
