<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\PaymentAccount;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat;

/**
 * @see https://developers.fattureincloud.it/api-reference#tag/Info
 */
class Info extends Api
{
    /**
     * List VAT types. OPTIONAL query: fieldset.
     *
     * @param  array{fieldset?: string}  $additional_data
     */
    public function listVatTypes(
        array $additional_data = []
    ): InfoList|Error {
        $additional_data = $this->data($additional_data, [
            'fieldset',
        ]);

        $response = $this->get(
            'c/'.$this->companyId.'/info/vat_types',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $vats = $response->data;

        return new InfoList($vats, Vat::class);
    }

    /**
     * List payment accounts. OPTIONAL query: fields, fieldset, sort.
     *
     * @param  array{fields?: string, fieldset?: string, sort?: string}  $additional_data
     */
    public function listPaymentAccounts(
        array $additional_data = []
    ): InfoList|Error {
        $additional_data = $this->data($additional_data, [
            'fields',
            'fieldset',
            'sort',
        ]);

        $response = $this->get(
            'c/'.$this->companyId.'/info/payment_accounts',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $accounts = $response->data;

        return new InfoList($accounts, PaymentAccount::class);
    }
}
