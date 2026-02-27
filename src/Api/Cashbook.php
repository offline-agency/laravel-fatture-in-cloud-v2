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

    /**
     * List cashbook entries. REQUIRED query: date_from, date_to (Y-m-d). OPTIONAL: fields, fieldset, sort, page, per_page, q.
     *
     * @param  array{date_from: string, date_to: string, fields?: string, fieldset?: string, sort?: string, page?: int, per_page?: int, q?: string}  $additionalData
     */
    public function list(array $additionalData = []): CashbookList|Error|MessageBag
    {
        $validator = Validator::make($additionalData, [
            'date_from' => 'required|date_format:'.self::DATE_FORMAT_YMD,
            'date_to' => 'required|date_format:'.self::DATE_FORMAT_YMD,
        ], [
            'date_from.required' => 'date_from is required (Y-m-d).',
            'date_to.required' => 'date_to is required (Y-m-d).',
            'date_from.date_format' => 'date_from must be Y-m-d.',
            'date_to.date_format' => 'date_to must be Y-m-d.',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $normalized = array_merge($additionalData, [
            'date_from' => $this->normalizeDateToYmd($additionalData['date_from']),
            'date_to' => $this->normalizeDateToYmd($additionalData['date_to']),
        ]);
        $additionalData = $this->data($normalized, [
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
            'date_from',
            'date_to',
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
     * Get all cashbook entries. REQUIRED query: date_from, date_to (Y-m-d). OPTIONAL: fields, fieldset, sort, page, per_page, q.
     *
     * @param  array{date_from: string, date_to: string, fields?: string, fieldset?: string, sort?: string, page?: int, per_page?: int, q?: string}  $additionalData
     * @return array<CashbookEntity>|Error|MessageBag
     */
    public function all(array $additionalData = []): array|Error|MessageBag
    {
        $validator = Validator::make($additionalData, [
            'date_from' => 'required|date_format:'.self::DATE_FORMAT_YMD,
            'date_to' => 'required|date_format:'.self::DATE_FORMAT_YMD,
        ], [
            'date_from.required' => 'date_from is required (Y-m-d).',
            'date_to.required' => 'date_to is required (Y-m-d).',
            'date_from.date_format' => 'date_from must be Y-m-d.',
            'date_to.date_format' => 'date_to must be Y-m-d.',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $normalized = array_merge($additionalData, [
            'date_from' => $this->normalizeDateToYmd($additionalData['date_from']),
            'date_to' => $this->normalizeDateToYmd($additionalData['date_to']),
        ]);
        $allCashbook = $this->getAll([
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
            'date_from',
            'date_to',
        ], 'c/'.$this->companyId.'/cashbook', $normalized);

        if ($allCashbook instanceof Error) {
            return $allCashbook;
        }

        return array_map(function ($cashbook) {
            return new CashbookEntity($cashbook);
        }, $allCashbook);
    }

    /**
     * Get single cashbook entry. OPTIONAL query: fields, fieldset.
     *
     * @param  array{fields?: string, fieldset?: string}  $additionalData
     */
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

    /**
     * Create cashbook entry. Body REQUIRED: data.date (Y-m-d), data.description, data.kind, data.payment_account_in.
     *
     * @param  array{data: array{date: string, description: string, kind: string, payment_account_in: mixed}}  $body
     */
    public function create(array $body = []): CashbookEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.date' => 'required|date_format:'.self::DATE_FORMAT_YMD,
            'data.description' => 'required',
            'data.kind' => 'required|in:cashbook,issued_document,received_document,tax,receipt',
            'data.payment_account_in' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $body = $this->normalizeBodyDate($body, 'data.date');

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

    /**
     * Edit cashbook entry. Body REQUIRED: data.date (Y-m-d), data.description, data.kind, data.payment_account_in.
     *
     * @param  array{data: array{date: string, description: string, kind: string, payment_account_in: mixed}}  $body
     */
    public function edit(int $entryId, array $body = []): CashbookEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.date' => 'required|date_format:'.self::DATE_FORMAT_YMD,
            'data.description' => 'required',
            'data.kind' => 'required|in:cashbook,issued_document,received_document,tax,receipt',
            'data.payment_account_in' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $body = $this->normalizeBodyDate($body, 'data.date');

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
