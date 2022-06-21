<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Supplier extends FakeResponse
{
    public function getSupplierFakeDetail(
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
            'vat_number' => $this->value($params, 'vat_number', 'fake_vat_number'),
            'tax_code' => $this->value($params, 'tax_code', 'fake_tax_code'),
            'address_street' => $this->value($params, 'address_street', 'fake_address_street'),
            'address_postal_code' => $this->value($params, 'address_postal_code', 'fake_address_postal_code'),
            'address_city' => $this->value($params, 'address_city', 'fake_address_city'),
            'address_province' => $this->value($params, 'address_province', 'fake_address_province'),
            'address_extra' => $this->value($params, 'address_extra', 'fake_address_extra'),
            'country' => $this->value($params, 'country', 'fake_country'),
            'email' => $this->value($params, 'email', 'fake_email'),
            'certified_email' => $this->value($params, 'certified_email', 'fake_certified_email'),
            'phone' => $this->value($params, 'phone', 'fake_phone'),
            'fax' => $this->value($params, 'fax', 'fake_fax'),
            'notes' => $this->value($params, 'notes', 'fake_notes'),
            'create_at' => $this->value($params, 'create_at', 'fake_create_at'),
            'updated_at' => $this->value($params, 'updated_at', 'fake_updated_at'),
        ];
    }
}
