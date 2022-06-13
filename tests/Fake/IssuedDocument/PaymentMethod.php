<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class PaymentMethod extends FakeResponse
{
    public function getPaymentMethodFake(
        array $params = []
    ): array
    {
        return [
            'id' => $this->value($params, 'payment_method.id', null),
            'name' => $this->value($params, 'payment_method.name', ''),
            'details' => $this->value($params, 'payment_method.details', [
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
            ]),
        ];
    }
}
