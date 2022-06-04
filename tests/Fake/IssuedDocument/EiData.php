<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class EiData extends FakeResponse
{
    public function getEiDataFake()
    {
        return (object)[
            'vat_kind' => null,
            'original_document_type' => null,
            'od_number' => '',
            'od_date' => date('Y-m-d'),
            'cig' => '',
            'cup' => '',
            'payment_method' => 'MP08',
            'bank_name' => '',
            'bank_iban' => '',
            'bank_beneficiary' => '',
        ];
    }
}
