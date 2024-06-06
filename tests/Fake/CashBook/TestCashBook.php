<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\CashBook;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class TestCashBook extends FakeResponse
{
    public function getFakeCashBook(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 'ABC123'),
            'date' => $this->value($params, 'date', '2024-06-05'),
            'description' => $this->value($params, 'description', 'Sample description'),
            'kind' => $this->value($params, 'kind', 'cashbook'),
            'type' => $this->value($params, 'type', 'in'),
            'entity_name' => $this->value($params, 'entity_name', 'John Doe'),
            'document' => [
                'id' => $this->value($params, 'document.id', 123),
                'type' => $this->value($params, 'document.type', 'invoice'),
                'path' => $this->value($params, 'document.path', '/path/to/document'),
            ],
            'amount_in' => $this->value($params, 'amount_in', 100.00),
            'payment_account_in' => [
                'id' => $this->value($params, 'payment_account_in.id', 456),
                'name' => $this->value($params, 'payment_account_in.name', 'Bank Account'),
                'type' => $this->value($params, 'payment_account_in.type', 'bank'),
                'iban' => $this->value($params, 'payment_account_in.iban', 'IT60X0542811101000000123456'),
                'sia' => $this->value($params, 'payment_account_in.sia', '123456'),
                'cuc' => $this->value($params, 'payment_account_in.cuc', 'ABCDEF'),
                'virtual' => $this->value($params, 'payment_account_in.virtual', false),
            ],
            'amount_out' => $this->value($params, 'amount_out', 50.00),
            'payment_account_out' => [
                'id' => $this->value($params, 'payment_account_out.id', 789),
                'name' => $this->value($params, 'payment_account_out.name', 'Cash Wallet'),
                'type' => $this->value($params, 'payment_account_out.type', 'standard'),
                'iban' => $this->value($params, 'payment_account_out.iban', null),
                'sia' => $this->value($params, 'payment_account_out.sia', null),
                'cuc' => $this->value($params, 'payment_account_out.cuc', null),
                'virtual' => $this->value($params, 'payment_account_out.virtual', false),
            ],
        ];
    }
}
