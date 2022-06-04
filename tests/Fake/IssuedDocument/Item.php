<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Item extends FakeResponse
{
    public function getItemFake()
    {
        return (object)[
            'product_id' => 0,
            'code' => '',
            'name' => 'fake_name',
            'measure' => '',
            'net_price' => 100,
            'category' => 'ecommerce',
            'id' => 1,
            'gross_price' => 100,
            'apply_withholding_taxes' => true,
            'discount' => 0,
            'discount_highlight' => false,
            'in_dn' => false,
            'qty' => 1,
            'vat' => (object)[
                'id' => 46,
                'value' => 0,
                'description' => 'Esente Art.10 DPR 633/72',
            ],
            'stock' => null,
            'description' => 'fake_description',
            'not_taxable' => false,
            'ei_raw' => null,
        ];
    }
}
