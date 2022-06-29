<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SingleReceipt extends FakeResponse
{
    public function getReceiptFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'name' => $this->value($params, 'name', 'fake_product_name'),
            'code' => $this->value($params, 'code', 'fake_product_code'),
            'net_price' => $this->value($params, 'net_price', 100.00),
            'gross_price' => $this->value($params, 'gross_price', 122.00),
            'use_gross_price' => $this->value($params, 'use_gross_price', true),
            'net_cost' => $this->value($params, 'net_cost', 100.00),
            'measure' => $this->value($params, 'measure', 'fake_measure'),
            'description' => $this->value($params, 'description', 'fake_description'),
            'category' => $this->value($params, 'category', 'fake_category'),
            'notes' => $this->value($params, 'notes', 'fake_notes'),
            'in_stock' => $this->value($params, 'in_stock', true),
            'stock_initial' => $this->value($params, 'stock_initial', 100.00),
            'stock_current' => $this->value($params, 'stock_current', 80.00),
            'average_cost' => $this->value($params, 'average_cost', 100.00),
            'average_price' => $this->value($params, 'average_price', 122.00),
            'created_at' => $this->value($params, 'created_at', ''),
            'updated_at' => $this->value($params, 'updated_at', ''),
        ];
    }
}
