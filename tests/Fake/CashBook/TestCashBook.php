<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\CashBook;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class TestCashBook extends FakeResponse
{
    public function getFakeCashBook(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', null),
            'date' => $this->value($params, 'date', null),
            'description' => $this->value($params, 'description', null),
            'kind' => $this->value($params, 'kind', null),
            'type' => $this->value($params, 'type', null),
            'entity_name' => $this->value($params, 'entity_name', null),
            'document' => [
                'id' => $this->value($params, 'document.id', null),
                'type' => $this->value($params, 'document.type', null),
                'path' => $this->value($params, 'document.path', null),
            ],
            'amount_in' => $this->value($params, 'amount_in', null),
            'payment_account_in' => [
                'id' => $this->value($params, 'payment_account_in.id', null),
                'name' => $this->value($params, 'payment_account_in.name', null),
                'type' => $this->value($params, 'payment_account_in.type', null),
                'iban' => $this->value($params, 'payment_account_in.iban', null),
                'sia' => $this->value($params, 'payment_account_in.sia', null),
                'cuc' => $this->value($params, 'payment_account_in.cuc', null),
                'virtual' => $this->value($params, 'payment_account_in.virtual', false),
            ],
            'amount_out' => $this->value($params, 'amount_out', null),
            'payment_account_out' => [
                'id' => $this->value($params, 'payment_account_out.id', null),
                'name' => $this->value($params, 'payment_account_out.name', null),
                'type' => $this->value($params, 'payment_account_out.type', null),
                'iban' => $this->value($params, 'payment_account_out.iban', null),
                'sia' => $this->value($params, 'payment_account_out.sia', null),
                'cuc' => $this->value($params, 'payment_account_out.cuc', null),
                'virtual' => $this->value($params, 'payment_account_out.virtual', false),
            ],
        ];
    }
}
