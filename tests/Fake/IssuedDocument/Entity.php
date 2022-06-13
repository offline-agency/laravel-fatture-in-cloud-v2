<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Entity extends FakeResponse
{
    public function getEntityFake(
        array $params = []
    ): array
    {
        return [
            'name' => $this->value($params, 'entity.name', 'John Doe'),
            'vat_number' => $this->value($params, 'entity.vat_number', ''),
            'tax_code' => $this->value($params, 'entity.tax_code', 'QMCNHV40S06F284H'),
            'address_street' => $this->value($params, 'entity.address_street', 'fake_address'),
            'address_postal_code' => $this->value($params, 'entity.address_postal_code', '94535'),
            'address_city' => $this->value($params, 'entity.address_city', 'fake_city'),
            'address_province' => $this->value($params, 'entity.address_province', 'fake_province'),
            'address_extra' => $this->value($params, 'entity.address_extra', ''),
            'country' => $this->value($params, 'entity.country', 'Italia'),
            'certified_email' => $this->value($params, 'entity.certified_email', ''),
            'ei_code' => $this->value($params, 'entity.ei_code', ''),
            'type' => $this->value($params, 'entity.type', null),
            'default_payment_terms' => $this->value($params, 'entity.default_payment_terms', 0),
            'default_payment_terms_type' => $this->value($params, 'entity.default_payment_terms_type', 'standard'),
            'shipping_address' => $this->value($params, 'entity.shipping_address', ''),
            'default_vat' => $this->value($params, 'entity.default_vat', null),
            'default_payment_method' => $this->value($params, 'entity.default_payment_method', null),
            'bank_name' => $this->value($params, 'entity.bank_name', ''),
            'bank_iban' => $this->value($params, 'entity.bank_iban', ''),
            'default_discount' => $this->value($params, 'entity.default_discount', 0),
            'discount_highlight' => $this->value($params, 'entity.discount_highlight', false),
            'has_intent_declaration' => $this->value($params, 'entity.has_intent_declaration', false),
            'intent_declaration_protocol_number' => $this->value($params, 'entity.intent_declaration_protocol_number', null),
            'intent_declaration_protocol_date' => $this->value($params, 'entity.intent_declaration_protocol_date', null),
            'originalName' => $this->value($params, 'entity.originalName', null)
        ];
    }
}
