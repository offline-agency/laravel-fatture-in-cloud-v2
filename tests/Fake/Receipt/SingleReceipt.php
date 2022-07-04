<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SingleReceipt extends FakeResponse
{
    public function getReceiptFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'date' => $this->value($params, 'date', 'fake_date'),
            'number' => $this->value($params, 'number', 1),
            'numeration' => $this->value($params, 'numeration', 'fake_numeration'),
            'amount_net' => $this->value($params, 'amount_net', 1),
            'amount_vat' => $this->value($params, 'amount_vat', 1),
            'amount_gross' => $this->value($params, 'amount_gross', 1),
            'use_gross_prices' => $this->value($params, 'use_gross_prices', true),
            'type' => $this->value($params, 'type', 'fake_type'),
            'description' => $this->value($params, 'description', 'fake_description'),
            'rc_center' => $this->value($params, 'rc_center', 'fake_rc_center'),
            'created_at' => $this->value($params, 'created_at', 'fake_created_at'),
            'updated_at' => $this->value($params, 'updated_at', 'fake_updated_at'),
            'payment_account' => $this->value($params, 'payment_account', [
                'id' => $this->value($params, 'id', 1),
                'name' => $this->value($params, 'name', 'fake_name'),
                'type' => $this->value($params, 'type', 'fake_type'),
                'iban' => $this->value($params, 'iban', 'fake_iban'),
                'sia' => $this->value($params, 'sia', 'fake_sia'),
                'cuc' => $this->value($params, 'cuc', 'fake_cuc'),
                'virtual' => $this->value($params, 'virtual', 'virtual'),
                ]),
                'items_list' => $this->value($params, 'items_list', [
                    'id' => $this->value($params, 'id', 1),
                    'amount_net' => $this->value($params, 'amount_net', 1),
                    'amount_gross' => $this->value($params, 'amount_gross', 1),
                    'category' => $this->value($params, 'category', 'fake_category'),
                    'vat' => $this->value($params, 'vat', [
                        'id' => $this->value($params, 'id', 1),
                        'value' => $this->value($params, 'value', 1),
                        'description' => $this->value($params, 'description', 'fake_description'),
                        'notes' => $this->value($params, 'notes', 'fake_notes'),
                        'e_invoice' => $this->value($params, 'e_invoice', true),
                        'ei_type' => $this->value($params, 'ei_type', 'fake_ei_type'),
                        'ei_description' => $this->value($params, 'ei_description', 'fake_ei_description'),
                        'editable' => $this->value($params, 'editable', true),
                        'is_disabled' => $this->value($params, 'is_disabled', true),
                    ]),
                ]),
        ];
    }
}
