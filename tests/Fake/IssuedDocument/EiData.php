<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class EiData extends FakeResponse
{
    public function getEiDataFake(
        array $params = []
    ): array {
        return [
            'vat_kind' => $this->value($params, 'ei_data.vat_kind', null),
            'original_document_type' => $this->value($params, 'ei_data.original_document_type', null),
            'od_number' => $this->value($params, 'ei_data.od_number', ''),
            'od_date' => $this->value($params, 'ei_data.od_date', date('Y-m-d')),
            'cig' => $this->value($params, 'ei_data.cig', ''),
            'cup' => $this->value($params, 'ei_data.cup', ''),
            'payment_method' => $this->value($params, 'ei_data.payment_method', 'MP08'),
            'bank_name' => $this->value($params, 'ei_data.bank_name', ''),
            'bank_iban' => $this->value($params, 'ei_data.bank_iban', ''),
            'bank_beneficiary' => $this->value($params, 'ei_data.bank_beneficiary', ''),
        ];
    }
}
