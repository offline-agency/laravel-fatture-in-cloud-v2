<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Currency;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Currencies;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Entity;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Item;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\ItemsValues;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Values;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Payment;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Vat;

class Document extends FakeResponse
{
    public function getIssuedDocumentFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'type' => $this->value($params, 'type', 'invoice'),
            'year' => $this->value($params, 'year', date('Y')),
            'numeration' => $this->value($params, 'numeration', 'E'),
            'subject' => $this->value($params, 'subject', ''),
            'visible_subject' => $this->value($params, 'visible_subject', ''),
            'rc_center' => $this->value($params, 'rc_center', 'ecommerce'),
            'amount_rivalsa' => $this->value($params, 'amount_rivalsa', 0),
            'amount_rivalsa_taxable' => $this->value($params, 'amount_rivalsa_taxable', 81),
            'amount_global_cassa_taxable' => $this->value($params, 'amount_global_cassa_taxable', 81),
            'amount_cassa' => $this->value($params, 'amount_cassa', 0),
            'amount_cassa_taxable' => $this->value($params, 'amount_cassa_taxable', 81),
            'amount_cassa2' => $this->value($params, 'amount_cassa2', 0),
            'amount_cassa2_taxable' => $this->value($params, 'amount_cassa2_taxable', 81),
            'amount_withholding_tax' => $this->value($params, 'amount_withholding_tax', 0),
            'amount_withholding_tax_taxable' => $this->value($params, 'amount_withholding_tax_taxable', 0),
            'amount_other_withholding_tax' => $this->value($params, 'amount_other_withholding_tax', 0),
            'amount_enasarco_taxable' => $this->value($params, 'amount_enasarco_taxable', 0),
            'amount_other_withholding_tax_taxable' => $this->value($params, 'amount_other_withholding_tax_taxable', 81),
            'ei_cassa_type' => $this->value($params, 'ei_cassa_type', null),
            'ei_cassa2_type' => $this->value($params, 'ei_cassa2_type', null),
            'ei_withholding_tax_causal' => $this->value($params, 'ei_withholding_tax_causal', null),
            'ei_other_withholding_tax_type' => $this->value($params, 'ei_other_withholding_tax_type', null),
            'ei_other_withholding_tax_causal' => $this->value($params, 'ei_other_withholding_tax_causal', null),
            'stamp_duty' => $this->value($params, 'stamp_duty', 0),
            'use_gross_prices' => $this->value($params, 'use_gross_prices', false),
            'e_invoice' => $this->value($params, 'e_invoice', true),
            'delivery_note' => $this->value($params, 'delivery_note', false),
            'accompanying_invoice' => $this->value($params, 'accompanying_invoice', false),
            'amount_net' => $this->value($params, 'amount_net', 81),
            'amount_vat' => $this->value($params, 'amount_vat', 0),
            'amount_gross' => $this->value($params, 'amount_gross', 81),
            'amount_due_discount' => $this->value($params, 'amount_due_discount', 0),
            'h_margins' => $this->value($params, 'h_margins', 15),
            'v_margins' => $this->value($params, 'v_margins', 16),
            'show_payment_method' => $this->value($params, 'show_payment_method', false),
            'show_payments' => $this->value($params, 'show_payments', true),
            'show_totals' => $this->value($params, 'show_totals', 'all'),
            'show_paypal_button' => $this->value($params, 'show_paypal_button', false),
            'show_notification_button' => $this->value($params, 'show_notification_button', false),
            'is_marked' => $this->value($params, 'is_marked', false),
            'created_at' => $this->value($params, 'created_at', date('Y-m-d H:i:s')),
            'updated_at' => $this->value($params, 'updated_at', date('Y-m-d H:i:s')),
            'entity' => (new Entity())->getEntityFake($params),
            'date' => $this->value($params, 'date', date('Y-m-d')),
            'number' => $this->value($params, 'number', 1),
            'currency' => (new Currency())->getCurrencyFake($params),
            'notes' => $this->value($params, 'notes', ''),
            'use_split_payment' => $this->value($params, 'use_split_payment', false),
            'original_document' => $this->value($params, 'original_document', null),
            'items_list' => [
                (new Item())->getItemFake($params),
                (new Item())->getItemFake($params),
            ],
            'payments_list' => [
                (new Payment())->getPaymentFake($params),
            ],
            'rivalsa' => $this->value($params, 'rivalsa', 0),
            'rivalsa_taxable' => $this->value($params, 'rivalsa_taxable', 100),
            'cassa' => $this->value($params, 'cassa', 0),
            'cassa2' => $this->value($params, 'cassa2', 0),
            'global_cassa_taxable' => $this->value($params, 'global_cassa_taxable', 100),
            'cassa_taxable' => $this->value($params, 'cassa_taxable', 100),
            'cassa2_taxable' => $this->value($params, '', 0),
            'withholding_tax' => $this->value($params, 'cassa2_taxable', 0),
            'withholding_tax_taxable' => $this->value($params, 'withholding_tax_taxable', 0),
            'other_withholding_tax' => $this->value($params, 'other_withholding_tax', 0),
            'other_withholding_tax_taxable' => $this->value($params, 'other_withholding_tax_taxable', 100),
            'seen_date' => $this->value($params, 'seen_date', null),
            'next_due_date' => $this->value($params, 'next_due_date', null),
            'show_tspay_button' => $this->value($params, 'show_tspay_button', false),
            'url' => $this->value($params, 'url', 'https://fake_url.com'),
            'attachment_url' => $this->value($params, 'attachment_url', null),
            'ei_raw' => $this->value($params, 'ei_raw', null),
            'ei_status' => $this->value($params, 'ei_status', 'not_sent'),
            'locked' => $this->value($params, 'locked', false),
            'has_ts_pay_pending_payment' => $this->value($params, 'has_ts_pay_pending_payment', false),
            'is_first_e_invoice' => $this->value($params, 'is_first_e_invoice', false),
        ];
    }
}
