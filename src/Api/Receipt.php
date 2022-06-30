<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\Receipt as ReceiptEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptList;

class Receipt extends Api
{
    public function list(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ]);

        $response = $this->get(
            $this->company_id.'/receipts',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipts = $response->data;

        return new ReceiptList($receipts);
    }

    public function detail(
        int $receipt_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            $this->company_id.'/receipts',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipts = $response->data->data;

        return new ReceiptEntity($receipts);
    }

    public function delete(
        int $receipt_id
    ) {
        $response = $this->destroy(
            $this->company_id.'/receipts'
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Receipt deleted';
    }

    public function create(
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.date' => 'required_without_all:data.code,data.description',
            'data.type' => 'required_without_all:data.name,data.description',
            'data.payment_account' => 'required_without_all:data.name,data.code',
            'data.payment_account.name' => 'required_without_all:data.name,data.code',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            $this->company_id.'/receipts',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipt = $response->data->data;

        return new ReceiptEntity($receipt);
    }

    public function edit(
        int $receipt_id,
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.date' => 'required_without_all:data.code,data.description',
            'data.type' => 'required_without_all:data.name,data.description',
            'data.payment_account' => 'required_without_all:data.name,data.code',
            'data.payment_account.name' => 'required_without_all:data.name,data.code',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            $this->company_id.'/receipts',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipt = $response->data->data;

        return new ReceiptEntity($receipt);
    }

    public function detail(
        int $receipt_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            $this->company_id.'/receipts',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipts = $response->data->data;

        return new ReceiptPreCreateInfo($receipts);
    }
}
