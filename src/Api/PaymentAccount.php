<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentAccount as PaymentAccountEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentAccountList;

class PaymentAccount extends Api
{
    public function list(): PaymentAccountList|Error
    {
        $response = $this->get(
            'c/'.$this->companyId.'/settings/payment_accounts',
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $paymentAccounts = $response->data;

        return new PaymentAccountList($paymentAccounts);
    }

    public function detail(int $paymentAccountId): PaymentAccountEntity|Error
    {
        $response = $this->get(
            'c/'.$this->companyId.'/settings/payment_accounts/'.$paymentAccountId,
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $paymentAccount = $response->data->data;

        return new PaymentAccountEntity($paymentAccount);
    }

    public function delete(int $paymentAccountId): string|Error
    {
        $response = $this->destroy(
            'c/'.$this->companyId.'/settings/payment_accounts/'.$paymentAccountId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Payment account deleted';
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function create(array $body = []): PaymentAccountEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->companyId.'/settings/payment_accounts',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $paymentAccount = $response->data->data;

        return new PaymentAccountEntity($paymentAccount);
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function edit(int $paymentAccountId, array $body = []): PaymentAccountEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            'c/'.$this->companyId.'/settings/payment_accounts/'.$paymentAccountId,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $paymentAccountResponse = $response->data->data;

        return new PaymentAccountEntity($paymentAccountResponse);
    }
}
