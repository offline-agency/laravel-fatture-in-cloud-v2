<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class ExtraData extends FakeResponse
{
    public function getExtraDataFake()
    {
        return (object) [
            'show_sofort_button'     => false,
            'multifatture_sent'      => null,
            'accountant_causal_code' => null,
            'ts_communication'       => false,
            'ts_tipo_spesa'          => null,
            'ts_flag_tipo_spesa'     => null,
            'ts_pagamento_tracciato' => null,
            'ts_opposizione'         => null,
            'ts_status'              => null,
            'ts_file_id'             => null,
            'ts_sent_date'           => null,
            'ts_full_amount'         => false,
            'imported_by'            => null,
            'ts_single_sending'      => null,
        ];
    }
}
