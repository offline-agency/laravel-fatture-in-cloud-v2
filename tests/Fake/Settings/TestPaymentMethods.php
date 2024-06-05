<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class TestPaymentMethods extends FakeResponse
{
    public function getFakePaymentMethods(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 4),
            'name' => $this->value($params, 'name', 'Default'),
            'type' => $this->value($params, 'type', 'User'),
            'is_default' => $this->value($params, 'is_default', false),
            'default_payment_account' => [
                'id' => $this->value($params, 'default_payment_account.id', null),
                'name' => $this->value($params, 'default_payment_account.name', null),
                'type' => $this->value($params, 'default_payment_account.type', null),
                'iban' => $this->value($params, 'default_payment_account.iban', null),
                'sia' => $this->value($params, 'default_payment_account.sia', null),
                'cuc' => $this->value($params, 'default_payment_account.cuc', null),
                'virtual' => $this->value($params, 'default_payment_account.virtual', null),
            ],
            'details' => [
                'title' => $this->value($params, 'details.title', null),
                'description' => $this->value($params, 'details.description', null),
            ],
            'bank_iban' => $this->value($params, 'bank_iban', 'AD1200012030200359100100'),
            'bank_name' => $this->value($params, 'bank_name', 'Padova'),
            'ei_payment_method' => $this->value($params, 'ei_payment_method', 'idk')
        ];
    }
}
