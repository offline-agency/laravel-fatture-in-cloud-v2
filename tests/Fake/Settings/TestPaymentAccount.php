<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class TestPaymentAccount extends FakeResponse
{
    public function getPaymentAccountFakeDetail(
        array $params = []
    ): array {
        return [
            'name' => $this->value($params, 'payment_account.name', 'John Doe'),
            'type' => $this->value($params, 'payment_account.type', null),
            'iban' => $this->value($params, 'payment_account.iban', ''),
            'sia' => $this->value($params, 'payment_account.sia', ''),
            'cuc' => $this->value($params, 'payment_account.cuc', ''),
            'virtual' => $this->value($params, 'payment_account.virtual', false)
        ];
    }
}
