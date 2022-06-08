<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\Document;

class IssuedDocumentFakeResponse extends FakeResponse
{
    public function getIssuedDocumentsFakeList()
    {
        return json_encode((object) [
            'current_page' => 1,
            'data'         => [
                (object) [
                    'id'                  => 1,
                    'type'                => 'fake_type',
                    'numeration'          => 'fake_numeration',
                    'subject'             => 'fake_subject',
                    'visible_subject'     => 'fake_visible_subject',
                    'amount_net'          => 100,
                    'amount_vat'          => 22,
                    'amount_gross'        => 122,
                    'amount_due_discount' => 0,
                    'entity'              => (object) [
                        'name'                => 'fake_name',
                        'vat_number'          => 'fake_vat_number',
                        'tax_code'            => 'fake_tax_code',
                        'address_street'      => 'fake_address_street',
                        'address_postal_code' => 'fake_address_postal_code',
                        'address_city'        => 'fake_address_city',
                        'address_province'    => 'fake_address_province',
                        'address_extra'       => 'fake_address_extra',
                        'country'             => 'fake_country',
                        'certified_email'     => 'fake_certified_email',
                        'ei_code'             => 'fake_ei_code',
                        'type'                => null,
                    ],
                    'date'          => 'fake_date',
                    'number'        => 1,
                    'next_due_date' => null,
                    'url'           => 'fake_url',
                ],
                (object) [
                    'id'                  => 2,
                    'type'                => 'fake_type',
                    'numeration'          => 'fake_numeration',
                    'subject'             => 'fake_subject',
                    'visible_subject'     => 'fake_visible_subject',
                    'amount_net'          => 100,
                    'amount_vat'          => 22,
                    'amount_gross'        => 122,
                    'amount_due_discount' => 0,
                    'entity'              => (object) [
                        'name'                => 'fake_name',
                        'vat_number'          => 'fake_vat_number',
                        'tax_code'            => 'fake_tax_code',
                        'address_street'      => 'fake_address_street',
                        'address_postal_code' => 'fake_address_postal_code',
                        'address_city'        => 'fake_address_city',
                        'address_province'    => 'fake_address_province',
                        'address_extra'       => 'fake_address_extra',
                        'country'             => 'fake_country',
                        'certified_email'     => 'fake_certified_email',
                        'ei_code'             => 'fake_ei_code',
                        'type'                => null,
                    ],
                    'date'          => 'fake_date',
                    'number'        => 2,
                    'next_due_date' => null,
                    'url'           => 'fake_url',
                ],
            ],
            'first_page_url' => 'fake_',
            'from'           => 1,
            'last_page'      => 2,
            'last_page_url'  => 'fake_last_page_url',
            'next_page_url'  => 'fake_next_page_url',
            'path'           => 'fake_path',
            'per_page'       => 50,
            'prev_page_url'  => null,
            'to'             => 50,
            'total'          => 50,
        ]);
    }

    public function getIssuedDocumentFakeDetail()
    {
        return json_encode((object) [
            'data' => (new Document())->getIssuedDocumentFakeDetail(),
        ]);
    }
}
