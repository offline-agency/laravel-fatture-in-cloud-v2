<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Item extends FakeResponse
{
    public function getItemFake(
        array $params = []
    ): array {
        return [
            'product_id' => $this->value($params, 'item.product_id', 0),
            'code' => $this->value($params, 'item.code', ''),
            'name' => $this->value($params, 'item.name', 'fake_name'),
            'measure' => $this->value($params, 'item.measure', ''),
            'net_price' => $this->value($params, 'item.net_price', 100),
            'category' => $this->value($params, 'item.category', 'ecommerce'),
            'id' => $this->value($params, 'item.id', 1),
            'gross_price' => $this->value($params, 'item.gross_price', 100),
            'apply_withholding_taxes' => $this->value($params, 'item.apply_withholding_taxes', true),
            'discount' => $this->value($params, 'item.discount', 0),
            'discount_highlight' => $this->value($params, 'item.discount_highlight', false),
            'in_dn' => $this->value($params, 'item.in_dn', false),
            'qty' => $this->value($params, 'item.qty', 1),
            'vat' => $this->value($params, 'item.vat', (object) [
                'id' => $this->value($params, 'item.vat.id', 46),
                'value' => $this->value($params, 'item.vat.value', 0),
                'description' => $this->value($params, 'item.vat.description', 'Esente Art.10 DPR 633/72'),
            ]),
            'stock' => $this->value($params, 'item.stock', null),
            'description' => $this->value($params, 'item.description', 'fake_description'),
            'not_taxable' => $this->value($params, 'item.not_taxable', false),
            'ei_raw' => $this->value($params, 'item.ei_raw', null),
        ];
    }
}
