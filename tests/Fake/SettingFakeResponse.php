<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Settings\TestPaymentMethods;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Settings\TestPaymentAccount;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Settings\TestVatType;

class SettingFakeResponse extends FakeResponse
{
    public function getPaymentMethodFakeDetail(
        array $params = []
    ): array {
        return (new TestPaymentMethods())->getFakePaymentMethods($params);
    }

    public function getPaymentAccountFakeDetail(
        array $params = []
    ): array {
        return (new TestPaymentAccount())->getPaymentAccountFakeDetail($params);
    }

    public function getVatTypeFakeDetail(
        array $params = []
    ): array {
        /*return json_encode([
            'data' => (new TestVatType())->getVatTypeFakeDetail($params),
        ]);*/
        return (new TestVatType())->getVatTypeFakeDetail($params);
    }
}
