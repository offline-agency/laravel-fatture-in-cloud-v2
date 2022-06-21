<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Client;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class DefaultPaymentMethod extends FakeResponse
{
    public function getDefaultPaymentDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'name' => $this->value($params, 'id', 1),
            'type' => $this->value($params, 'id', 1),
            'is_default' => $this->value($params, 'id', 1),
            'default_payment_account' => $this->value($params, 'id', null),
            'details' => $this->value($params, 'id', null),
            'bank_iban' => $this->value($params, 'id', 1),
            'bank_name' => $this->value($params, 'id', 1),
            'bank_beneficiary' => $this->value($params, 'id', 1),
            'ei_payment_method' => $this->value($params, 'id', 1),
        ];
    }
}
