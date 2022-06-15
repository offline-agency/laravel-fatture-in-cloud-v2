<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Client;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SingleClient extends FakeResponse
{
    public function getClientFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'code' => $this->value($params, 'code', 'fake_code'),
            'name' => $this->value($params, 'name', 'fake_name'),
            'type' => $this->value($params, 'type', 'fake_type'),
            'first_name' => $this->value($params, 'first_name', 'fake_first_name'),
            'last_name' => $this->value($params, 'last_name', 'fake_last_name'),
            'contact_person' => $this->value($params, 'contact_person', 'fake_contact_person'),
            'vat_number' => $this->value($params, 'vat_number', '01234567891'),
            'tax_code' => $this->value($params, 'tax_code', 'fake_tax_code'),
            'address_street' => $this->value($params, 'address_street', 'fake_address_street'),
            'address_postal_code' => $this->value($params, 'address_postal_code', 'fake_address_postal_code'),
            'address_city' => $this->value($params, 'address_city', 'fake_address_city'),
            'address_province' => $this->value($params, 'address_province', 'fake_address_province'),
            'address_extra' => $this->value($params, 'address_extra', 'fake_address_extra'),
            'country' => $this->value($params, 'country', 'Italia'),
            'email' => $this->value($params, 'email', 'fake_code@gmail.com'),
            'certified_email' => $this->value($params, 'certified_email', 'fake_certified_email@pec.it'),
            'phone' => $this->value($params, 'phone', '3333333333'),
            'fax' => $this->value($params, 'fax', 'fake_fax'),
            'notes' => $this->value($params, 'notes', 'fake_notes'),
            'default_vat' => (new DefaultVat())->getDefaultVatDetail($params),
            'default_payment_terms' => $this->value($params, 'default_payment_terms', 1),
            'default_payment_terms_type' => $this->value($params, 'default_payment_terms_type', 'fake_default_payment_terms_type'),
            'default_payment_method' => (new DefaultPaymentMethod())->getDefaultPaymentDetail($params),
            'bank_name' => $this->value($params, 'bank_name', 'fake_bank_name'),
            'bank_iban' => $this->value($params, 'bank_iban', 'fake_bank_iban'),
            'bank_swift_code' => $this->value($params, 'bank_swift_code', 'fake_bank_swift_code'),
            'shipping_address' => $this->value($params, 'shipping_address', 'fake_shipping_address'),
            'e_invoice' => $this->value($params, 'e_invoice', false),
            'ei_code' => $this->value($params, 'ei_code', 'fake_ei_code'),
            'discount_highlight' => $this->value($params, 'discount_highlight', false),
            'default_discount' => $this->value($params, 'default_discount', 0),
            'has_intent_declaration' => $this->value($params, 'has_intent_declaration', false),
            'intent_declaration_protocol_number' => $this->value($params, 'intent_declaration_protocol_number', 'fake_intent_declaration_protocol_number'),
            'intent_declaration_protocol_date' => $this->value($params, 'intent_declaration_protocol_date', 'fake_intent_declaration_protocol_date'),
            'created_at' => $this->value($params, 'created_at', 'fake_created_at'),
            'updated_at' => $this->value($params, 'updated_at', 'fake_updated_at')
        ];
    }
}
