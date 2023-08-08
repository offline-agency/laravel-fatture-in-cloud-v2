<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SinglePaymentAccount extends FakeResponse
{
    public function getPaymentAccountFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'name' => $this->value($params, 'name', 'Default payment account'),
            'type' => $this->value($params, 'type', 'standard'),
            'iban' => $this->value($params, 'iban', ''),
            'sia' => $this->value($params, 'sia', ''),
            'cuc' => $this->value($params, 'cuc', ''),
            'virtual' => $this->value($params, 'virtual', false),
        ];
    }
}
