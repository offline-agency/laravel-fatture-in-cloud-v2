<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Entity extends FakeResponse
{
    public function getEntityFake()
    {
        return (object)[
            'name' => 'John Doe',
            'vat_number' => '',
            'tax_code' => 'QMCNHV40S06F284H',
            'address_street' => 'fake_address',
            'address_postal_code' => '94535',
            'address_city' => 'fake_city',
            'address_province' => 'fake_province',
            'address_extra' => '',
            'country' => 'Italia',
            'certified_email' => '',
            'ei_code' => '',
            'type' => null,
            'default_payment_terms' => 0,
            'default_payment_terms_type' => 'standard',
            'shipping_address' => '',
            'default_vat' => null,
            'default_payment_method' => null,
            'bank_name' => '',
            'bank_iban' => '',
            'default_discount' => 0,
            'discount_highlight' => false,
            'has_intent_declaration' => false,
            'intent_declaration_protocol_number' => null,
            'intent_declaration_protocol_date' => null,
            'originalName' => null
        ];
    }
}
