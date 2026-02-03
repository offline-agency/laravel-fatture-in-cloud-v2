<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SinglePaymentAccounts extends FakeResponse
{
    public function getPaymentAccountsTypeFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'name'=> $this->value($params, 'name', 'fake_name'),
            'type' =>$this-> value($params, 'type', 'fake_type'),
            'iban' => $this->value($params, 'iban', 'fake_iban'),
            'sia' => $this->value($params, 'sia', 'fake_sia'),
            'cuc' => $this->value($params, 'cuc', 'fake_cuc'),
            'virtual' => $this->value($params, 'virtual', 'true'),
        ];
    }
}
