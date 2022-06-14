<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class ExtraData extends FakeResponse
{
    public function getExtraDataFake(
        array $params = []
    ): array {
        return [
            'show_sofort_button' => $this->value($params, 'extra_data.show_sofort_button', false),
            'multifatture_sent' => $this->value($params, 'extra_data.multifatture_sent', null),
            'accountant_causal_code' => $this->value($params, 'extra_data.accountant_causal_code', null),
            'ts_communication' => $this->value($params, 'extra_data.ts_communication', false),
            'ts_tipo_spesa' => $this->value($params, 'extra_data.ts_tipo_spesa', null),
            'ts_flag_tipo_spesa' => $this->value($params, 'extra_data.ts_flag_tipo_spesa', null),
            'ts_pagamento_tracciato' => $this->value($params, 'extra_data.ts_pagamento_tracciato', null),
            'ts_opposizione' => $this->value($params, 'extra_data.ts_opposizione', null),
            'ts_status' => $this->value($params, 'extra_data.ts_status', null),
            'ts_file_id' => $this->value($params, 'extra_data.ts_file_id', null),
            'ts_sent_date' => $this->value($params, 'extra_data.ts_sent_date', null),
            'ts_full_amount' => $this->value($params, 'extra_data.ts_full_amount', false),
            'imported_by' => $this->value($params, 'extra_data.imported_by', null),
            'ts_single_sending' => $this->value($params, 'extra_data.ts_single_sending', null),
        ];
    }
}
