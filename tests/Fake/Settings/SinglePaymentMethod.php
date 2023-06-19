<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SinglePaymentMethod extends FakeResponse
{
    public function getPaymentMethodFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'name' => $this->value($params, 'name', 'fake_name'),
            'type' => $this->value($params, 'type', 'fake_type'),
            'is_default' => $this->value($params, 'is_default', true),
            'default_payment_account' => (new DefaultPaymentAccount())->getDefaultPaymentDetail($params),
            'details' => $this->value($params, 'details', [
                'title' => $this->value($params, 'id', 'fake_title'),
                'description' => $this->value($params, 'name', 'fake_description'),
            ]),
            'bank_iban' => $this->value($params, 'bank_iban', 'fake_bank_iban'),
            'bank_name' => $this->value($params, 'bank_name', 'fake_bank_name'),
            'bank_beneficiary' => $this->value($params, 'bank_beneficiary', 'fake_bank_beneficiary'),
            'ei_payment_method' => $this->value($params, 'ei_payment_method', 'fake_ei_payment_method'),
        ];
    }
}
