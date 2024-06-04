<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Item extends FakeResponse
{
    public function getItemFake(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'item.id', 1),
            'product_id' => $this->value($params, 'item.product_id', 0),
            'code' => $this->value($params, 'item.code', ''),
            'name' => $this->value($params, 'item.name', 'fake_name'),
            'measure' => $this->value($params, 'item.measure', ''),
            'net_price' => $this->value($params, 'item.net_price', 100),
            'category' => $this->value($params, 'item.category', 'ecommerce'),
            'qty' => $this->value($params, 'item.qty', 1),
            'vat' => $this->value($params, 'item.vat', (object) [
                'id' => $this->value($params, 'item.vat.id', 46),
                'value' => $this->value($params, 'item.vat.value', 0),
                'description' => $this->value($params, 'item.vat.description', 'Esente Art.10 DPR 633/72'),
            ]),
            'stock' => $this->value($params, 'item.stock', null),
        ];
    }
}
