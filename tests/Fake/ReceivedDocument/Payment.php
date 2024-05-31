<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Payment extends FakeResponse
{
    public function getPaymentFake(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'payment.id', 1),
            'amount' => $this->value($params, 'payment.amount', 81),
            'due_date' => $this->value($params, 'payment.due_date', date('Y-m-d')),
            'paid_date' => $this->value($params, 'payment.paid_date', date('Y-m-d')),
            'payment_terms' => $this->value($params, 'payment.payment_terms', (object) [
                'days' => $this->value($params, 'payment.payment_terms.days', 7),
                'type' => $this->value($params, 'payment.payment_terms.type', 'invoice'),
            ]),
            'status' => $this->value($params, 'payment.status', 'paid'),
            'payment_account' => $this->value($params, 'payment.payment_account', (object) [
                'id' => $this->value($params, 'payment.payment_account.id', 1),
                'name' => $this->value($params, 'payment.payment_account.name', 'Braintree'),
                'type' => $this->value($params, 'payment.payment_account.type', 'invoice'),
                'iban' => $this->value($params, 'payment.payment_account.iban', 'fake_iban'),
                'sia' => $this->value($params, 'payment.payment_account.sia', 'fake_sia'),
                'cuc' => $this->value($params, 'payment.payment_account.cuc', 'fake_cuc'),
                'virtual' => $this->value($params, 'payment.payment_account.virtual', false),
            ])
        ];
    }
}
