<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Taxes;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class PaymentAccount extends FakeResponse
{
    public function getPaymentAccountFake(
        array $params = []
    ) {
        return [
            'name' => $this->value($params, 'paymentaccount.name', 'John Doe'),
            'type' => $this->value($params, 'paymentaccount.type', null),
            'iban' => $this->value($params, 'paymentaccount.iban', ''),
            'sia' => $this->value($params, 'paymentaccount.sia', ''),
            'cuc' => $this->value($params, 'paymentaccount.cuc', ''),
            'virtual' => $this->value($params, 'paymentaccout.virtal', false)
        ];
    }
}
