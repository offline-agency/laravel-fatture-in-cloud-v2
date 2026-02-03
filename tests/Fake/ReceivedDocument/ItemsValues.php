<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class ItemsValues extends FakeResponse
{
    public function getItemsValuesFake(
        array $params = []
    ): array
    {
        return [
            'vat' => $this->value($params, 'itemsValues.vat', 'fake_vat'),
        ];
    }
}
