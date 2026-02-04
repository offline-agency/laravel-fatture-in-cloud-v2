<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
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
        'till_receipt',
    ];

    public function list(array $additionalData = []): ReceiptList|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/receipts',
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipts = $response->data;

        return new ReceiptList($receipts);
    }

    /**
     * @return array<ReceiptEntity>|Error
     */
    public function all(array $additionalData = []): array|Error
    {
        $allReceipts = $this->getAll([
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
        ], 'c/'.$this->companyId.'/receipts', $additionalData);

        if ($allReceipts instanceof Error) {
            return $allReceipts;
        }

        return array_map(function ($receipt) {
            return new ReceiptEntity($receipt);
        }, $allReceipts);
    }

    public function detail(int $receiptId, array $additionalData = []): ReceiptEntity|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/receipts/'.$receiptId,
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipt = $response->data->data;

        return new ReceiptEntity($receipt);
    }

    public function delete(int $receiptId): string|Error
    {
        /** @var object $response */
        $response = $this->destroy(
            'c/'.$this->companyId.'/receipts/'.$receiptId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Receipt deleted';
    }

    public function create(array $body = []): ReceiptEntity|Error|MessageBag
    {
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

        /** @var object $response */
        $response = $this->post(
            'c/'.$this->companyId.'/receipts',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipt = $response->data->data;

        return new ReceiptEntity($receipt);
    }

    public function edit(int $receiptId, array $body = []): ReceiptEntity|Error|MessageBag
    {
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

        /** @var object $response */
        $response = $this->put(
            'c/'.$this->companyId.'/receipts/'.$receiptId,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipt = $response->data->data;

        return new ReceiptEntity($receipt);
    }

    public function preCreateInfo(): ReceiptPreCreateInfo|Error
    {
        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/receipts/info',
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receiptsInfo = $response->data->data;

        return new ReceiptPreCreateInfo($receiptsInfo);
    }

    /**
     * @return array<ReceiptMonthlyTotals>|Error|MessageBag
     */
    public function monthlyTotals(string $type, string $year): array|Error|MessageBag
    {
        $validator = Validator::make(['type' => $type], [
            'type' => 'required|in:'.implode(',', self::RECEIPT_TYPES),
        ], [
            'type.in' => 'The selected type is invalid. Select one between '.implode(', ', self::RECEIPT_TYPES),
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/receipts/monthly_totals',
            [
                'type' => $type,
                'year' => $year,
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
