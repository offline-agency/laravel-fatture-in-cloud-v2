<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Product;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class DefaultVat extends FakeResponse
{
    public function getDefaultVatFake(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'default_vat.id', 0),
            'value' => $this->value($params, 'default_vat.value', 22),
            'description' => $this->value($params, 'default_vat.description', ''),
            'is_disabled' => $this->value($params, 'default_vat.is_disabled', false)
        ];
    }
}
