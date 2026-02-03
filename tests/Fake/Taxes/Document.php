<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Taxes;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Document extends FakeResponse
{
    public function getTaxesFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'due_date' => $this->value($params, 'due_date', date('Y-m-d')),
            'status' => $this->value($params, 'status', null),
            'payment_account' => (new PaymentAccount())->getPaymentAccountFake($params),
            'amount' => $this->value($params, 'amount', 0),
            'attachment_url' => $this->value($params, 'attachment_url', ''),
            'description' => $this->value($params, 'description', '')
        ];
    }
}
