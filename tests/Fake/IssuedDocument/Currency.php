<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Currency extends FakeResponse
{
    public function getCurrencyFake()
    {
        return (object)[
            'id' => 'EUR',
            'exchange_rate' => '1.00000',
            'symbol' => '€'
        ];
    }
}
