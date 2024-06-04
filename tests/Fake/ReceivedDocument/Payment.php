<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Payment extends FakeResponse
{
    public function getPaymentFake(
        array $params = []
    ): array {
        return [
            'amount' => $this->value($params, 'payment.amount', 81),
            'due_date' => $this->value($params, 'payment.due_date', date('Y-m-d')),
            'paid_date' => $this->value($params, 'payment.paid_date', date('Y-m-d')),
            'id' => $this->value($params, 'payment.id', 1),
            'payment_terms' => $this->value($params, 'payment.payment_terms', null),
            'status' => $this->value($params, 'payment.status', 'paid'),
            'payment_account' => $this->value($params, 'payment.payment_account', (object) [
                'id' => $this->value($params, 'payment.payment_account.id', 1),
                'name' => $this->value($params, 'payment.payment_account.name', 'Braintree'),
                'virtual' => $this->value($params, 'payment.payment_account.virtual', false),
            ]),
            'ei_raw' => $this->value($params, 'payment.ei_raw', null),
        ];
    }
}
