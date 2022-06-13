<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Currency extends FakeResponse
{
    public function getCurrencyFake(
        array $params = []
    ): array
    {
        return [
            'id' => $this->value($params, 'currency.id', 'EUR'),
            'exchange_rate' => $this->value($params, 'currency.exchange_rate', '1.00000'),
            'symbol' => $this->value($params, 'currency.symbol', '€')
        ];
    }
}
