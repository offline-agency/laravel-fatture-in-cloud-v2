<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\PaymentAccount;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat;

class Info extends Api
{
    public function listVatTypes(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fieldset',
        ]);

        $response = $this->get(
            $this->company_id.'/info/vat_types',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $vats = $response->data;

        return new InfoList($vats, Vat::class);
    }

    public function listPaymentAccounts(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields',
            'fieldset',
            'sort'
        ]);

        $response = $this->get(
            $this->company_id.'/info/payment_accounts',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $accounts = $response->data;

        return new InfoList($accounts, PaymentAccount::class);
    }
}
