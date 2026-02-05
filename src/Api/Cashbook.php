<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook\CashbookEntry as CashbookEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook\CashbookList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class Cashbook extends Api
{
    use ListTrait;

    public function list(array $additionalData = []): CashbookList|Error
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
            'c/'.$this->companyId.'/cashbook',
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $cashbook = $response->data;

        return new CashbookList($cashbook);
    }

    /**
     * @return array<CashbookEntity>|Error
     */
    public function all(array $additionalData = []): array|Error
    {
        $allCashbook = $this->getAll([
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
        ], 'c/'.$this->companyId.'/cashbook', $additionalData);

        if ($allCashbook instanceof Error) {
            return $allCashbook;
        }

        return array_map(function ($cashbook) {
            return new CashbookEntity($cashbook);
        }, $allCashbook);
    }

    public function detail(int $entryId, array $additionalData = []): CashbookEntity|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/cashbook/'.$entryId,
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $cashbook = $response->data->data;

        return new CashbookEntity($cashbook);
    }

    public function delete(int $entryId): string|Error
    {
        /** @var object $response */
        $response = $this->destroy(
            'c/'.$this->companyId.'/cashbook/'.$entryId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Cashbook entry deleted';
    }

    public function create(array $body = []): CashbookEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.date' => 'required',
            'data.description' => 'required',
            'data.kind' => 'required|in:cashbook,issued_document,received_document,tax,receipt',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->post(
            'c/'.$this->companyId.'/cashbook',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $cashbook = $response->data->data;

        return new CashbookEntity($cashbook);
    }

    public function edit(int $entryId, array $body = []): CashbookEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.date' => 'required',
            'data.description' => 'required',
            'data.kind' => 'required|in:cashbook,issued_document,received_document,tax,receipt',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->put(
            'c/'.$this->companyId.'/cashbook/'.$entryId,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $cashbookResponse = $response->data->data;

        return new CashbookEntity($cashbookResponse);
    }
}
