<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Currencies extends FakeResponse
{
    public function getCurrenciesFake(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'currencies.id', 'fake_id'),
            'symbol' => $this->value($params, 'currencies.symbol', 'paid'),
            'exchange_rate' => $this->value($params, 'currencies.exchange_rate', 'fake_exchange_rate'),
            'html_symbol' => $this->value($params, 'currencies.html_symbol', 'fake_html_symbol'),
        ];
    }
}

