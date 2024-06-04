<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Document extends FakeResponse
{
    public function  getReceivedDocumentFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'type' => $this->value($params, 'type', 'invoice'),
            'entity' => (new Entity())->getEntityFake($params),
            'date' => $this->value($params, 'date', date('Y-m-d')),
            'category' => $this->value($params, 'category', ''),
            'description' => $this->value($params, 'description', ''),
            'amount_net' => $this->value($params, 'amount_net', 81),
            'amount_vat' => $this->value($params, 'amount_vat', 0),
            'amount_withholding_tax' => $this->value($params, 'amount_withholding_tax', 0),
            'amount_other_withholding_t ax' => $this->value($params, 'amount_other_withholding_tax', 0),
            'amount_gross' => $this->value($params, 'amount_gross', 81),
            'amortization' => $this->value($params, 'amortization', ''),
            'rc_center' => $this->value($params, 'rc_center', 'ecommerce'),
            'invoice_number' => $this->value($params, 'invoice_number', ''),
            'is_marked' => $this->value($params, 'is_marked', false),
            'is_detailed' => $this->value($params, 'is_detailed', null),
            'e_invoice' => $this->value($params, 'e_invoice', false),
            'next_due_date' => $this->value($params, 'next_due_date', null),
            'currency' => (new Currency())->getCurrencyFake($params),
            'tax_deductibility' => $this->value($params, 'tax_deductibility', ''),
            'vat_deductibility' => $this->value($params, 'vat_deductibility', ''),
            'items_list' => [
                (new Item())->getItemFake($params),
                (new Item())->getItemFake($params),
            ],
            'payments_list' => [
                (new Payment())->getPaymentFake($params),
            ],
            'attachment_url' => $this->value($params, 'attachment_url', null),
            'attachment_preview_url' => $this->value($params, 'attachment_preview_url', ''),
            'auto_calculate' => $this->value($params, 'auto_calculate', ''),
            'attachment_token' => $this->value($params, 'attachment_token', ''),
            'locked' => $this->value($params, 'locked', false),
            'created_at' => $this->value($params, 'created_at', date('Y-m-d H:i:s')),
            'updated_at' => $this->value($params, 'updated_at', date('Y-m-d H:i:s'))
        ];
    }
}
