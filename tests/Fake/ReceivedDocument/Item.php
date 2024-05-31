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
                'notes' => $this->value($params, 'item.vat.description', 'fake_notes'),
                'e_invoice' => $this->value($params, 'item.vat.e_invoice', 'false'),
                'ei_type' => $this->value($params, 'item.vat.ei_type', 'fake_ei_type'),
                'ei_description' => $this->value($params, 'item.vat.ei_description', 'fake_ei_description'),
                'editable' => $this->value($params, 'item.vat.editable', 'false'),
                'is_disabled' => $this->value($params, 'item.vat.is_disabled', 'false'),
            ]),
            'stock' => $this->value($params, 'item.stock', null),
        ];
    }
}
