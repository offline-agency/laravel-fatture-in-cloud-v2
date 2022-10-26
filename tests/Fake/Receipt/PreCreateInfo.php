<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class PreCreateInfo extends FakeResponse
{
    public function getReceiptFakePreCreateInfo(
        array $params = []
    ): array {
        return [
            'numerations' => $this->value($params, 'updated_at', []),
            'numerations_list' => $this->value($params, 'numerations_list', 'fake_numerations_list'),
            'rc_centers_list' => $this->value($params, 'rc_centers_list', 'fake_rc_centers_list'),
            'payment_accounts_list' => $this->value($params, 'payment_accounts_list', [
                [
                    'id' => 1,
                    'name' => 'Braintree',
                ], [
                    'id' => 2,
                    'name' => 'PAYPAL',
                ],
            ]),
            'categories_list' => $this->value($params, 'categories_list', 'fake_categories_list'),
            'vat_types_list' => $this->value($params, 'vat_types_list', [
                [
                    'id' => 0,
                    'value' => 22,
                    'description' => '',
                    'ei_type' => '0',
                    'is_disabled' => false,
                ], [
                    'id' => 1,
                    'value' => 21,
                    'description' => '',
                    'ei_type' => '0',
                    'is_disabled' => false,
                ],
            ]),
        ];
    }
}
