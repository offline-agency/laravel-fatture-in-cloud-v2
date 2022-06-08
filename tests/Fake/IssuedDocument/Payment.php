<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Payment extends FakeResponse
{
    public function getPaymentFake()
    {
        return (object) [
            'amount'          => 81,
            'due_date'        => date('Y-m-d'),
            'paid_date'       => date('Y-m-d'),
            'id'              => 1,
            'payment_terms'   => null,
            'status'          => 'paid',
            'payment_account' => (object) [
                'id'      => 1,
                'name'    => 'Braintree',
                'virtual' => false,
            ],
            'ei_raw' => null,
        ];
    }
}
