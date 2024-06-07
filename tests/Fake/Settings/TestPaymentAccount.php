<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class TestPaymentAccount extends FakeResponse
{
    public function getFakePaymentAccount(
        array $param = []
    ): array {
        return [
            'id' => $this->value($param, 'id', 1),
            'name' => $this->value($param, 'name', null),
            'type' => $this->value($param, 'type', null),
            'iban' => $this->value($param, 'iban', null),
            'sia' => $this->value($param, 'sia', null),
            'cuc' => $this->value($param, 'cuc', null),
            'virtual' => $this->value($param, 'virtual', true),
        ];
    }
}
