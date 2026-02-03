<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\Settings as AccountEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\Settings as MethodEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\Settings as VatTypeEntity;

class Settings extends Api
{
    //===Method===
    public function mCreate(
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->company_id.'/settings/payment_methods',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $settings = $response->data->data;

        return new MethodEntity($settings);
    }
    public function mDetail(
        int $payment_method_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            'c/'.$this->company_id.'/settings/payment_methods'.$payment_method_id,
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $settings = $response->data->data;

        return new MethodEntity($settings);
    }

    public function mEdit(
        int $payment_method_id,
        ?array $body = []
    ){
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            'c/' . $this->company_id . '/settings/payment_methods/' . $payment_method_id,
            $body
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $payment_method_id = $response->data->data;

        return new MethodEntity($payment_method_id);
    }

    public function mDelete(
        int $payment_method_id
    )
    {
        $response = $this->destroy(
            'c/' . $this->company_id . '/settings/payment_methods/' . $payment_method_id
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        return 'Payment method deleted';
    }

    //===Account===

    public function aCreate(
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->company_id.'/settings/payment_accounts',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $settings = $response->data->data;

        return new AccountEntity($settings);
    }

    public function aDetail(
        int $payment_account_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            'c/'.$this->company_id.'/settings/payment_accounts' . $payment_account_id,
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $settings = $response->data->data;

        return new AccountEntity($settings);
    }

    public function aEdit(
        int $payment_account_id,
        ?array $body = []
    ){
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            'c/' . $this->company_id . '/settings/payment_accounts/' . $payment_account_id,
            $body
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $payment_account_id = $response->data->data;

        return new AccountEntity($payment_account_id);
    }

    public function aDelete(
        int $payment_account_id
    )
    {
        $response = $this->destroy(
            'c/' . $this->company_id . '/settings/payment_accounts/' . $payment_account_id
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        return 'Payment method deleted';
    }

    //===Vat_Type===
    public function vtCreate(
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->company_id.'/settings/vat_types',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $settings = $response->data->data;

        return new VatTypeEntity($settings);
    }

    public function vtDetail(
        int $vat_type_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            'c/'.$this->company_id.'/settings/vat_types'.$vat_type_id,
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $settings = $response->data->data;

        return new VatTypeEntity($settings);
    }

    public function vtEdit(
        int $vat_type_id,
        ?array $body = []
    ){
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            'c/' . $this->company_id . '/settings/vat_types/' . $vat_type_id,
            $body
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $vat_type_id = $response->data->data;

        return new VatTypeEntity($vat_type_id);
    }

    public function vtDelete(
        int $vat_type_id
    ){
        $response = $this->destroy(
            'c/' . $this->company_id . '/settings/vat_types/' . $vat_type_id
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        return 'Vat type deleted';
    }
}
