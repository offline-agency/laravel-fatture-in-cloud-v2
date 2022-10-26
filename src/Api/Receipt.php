<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\Receipt as ReceiptEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptMonthlyTotals;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptPreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class Receipt extends Api
{
    use ListTrait;

    const RECEIPT_TYPES = [
        'sales_receipt',
        'till_receipt'
    ];

    public function list(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ]);

        $response = $this->get(
            'c/'.$this->company_id.'/receipts',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipts = $response->data;

        return new ReceiptList($receipts);
    }

    public function all(
        ?array $additional_data = []
    ) {
        $all_receipts = $this->getAll([
            'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ], 'c/'.$this->company_id.'/receipts', $additional_data);

        return gettype($all_receipts) !== 'array'
            ? $all_receipts
            : array_map(function ($receipt) {
                return new ReceiptEntity($receipt);
            }, $all_receipts);
    }

    public function detail(
        int $receipt_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            'c/'.$this->company_id.'/receipts/'.$receipt_id,
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
            'c/'.$this->company_id.'/receipts/'.$receipt_id
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
            'c/'.$this->company_id.'/receipts',
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
            'c/'.$this->company_id.'/receipts/'.$receipt_id,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipt = $response->data->data;

        return new ReceiptEntity($receipt);
    }

    public function preCreateInfo() {
        $response = $this->get(
            'c/'.$this->company_id.'/receipts/info',
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipts = $response->data->data;

        return new ReceiptPreCreateInfo($receipts);
    }

    public function monthlyTotals(
        string $type,
        string $year
    ) {
        $validator = Validator::make(['type' => $type], [
            'type' => 'required|in:'.implode(',', Receipt::RECEIPT_TYPES),
        ], [
            'type.in' => 'The selected type is invalid. Select one between '.implode(', ', Receipt::RECEIPT_TYPES),
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->get(
            'c/'.$this->company_id.'/receipts/monthly_totals',
            [
                'type' => $type,
                'year' => $year
            ]
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipts = $response->data->data;

        return array_map(function ($receipt) {
            return new ReceiptMonthlyTotals($receipt);
        }, $receipts);
    }
}
