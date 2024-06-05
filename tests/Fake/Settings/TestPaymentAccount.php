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
            'name' => $this->value($param, 'name', 'Mario'),
            'type' => $this->value($param, 'type', 'admin'),
            'iban' => $this->value($param, 'iban', 'IT60X0542811101000000123456'),
            'sia' => $this->value($param, 'sia', 'I5jF9'),
            'cuc' => $this->value($param, 'cuc', 'SIAI5jF9'),
            'virtual' => $this->value($param, 'virtual', true),
        ];
    }
}
