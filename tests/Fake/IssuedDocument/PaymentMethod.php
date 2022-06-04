<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class PaymentMethod extends FakeResponse
{
    public function getPaymentMethodFake()
    {
        return (object)[
            'id' => null,
            'name' => '',
            'details' => [
                (object)[
                    'title' => '',
                    'description' => '',
                ],
                (object)[
                    'title' => '',
                    'description' => '',
                ],
                (object)[
                    'title' => '',
                    'description' => '',
                ],
                (object)[
                    'title' => '',
                    'description' => '',
                ],
                (object)[
                    'title' => '',
                    'description' => '',
                ],
            ],
        ];
    }
}
