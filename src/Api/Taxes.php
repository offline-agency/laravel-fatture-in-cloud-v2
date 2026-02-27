<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\Taxes as TaxesEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\TaxesAttachment;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\TaxesList;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class Taxes extends Api
{
    use ListTrait;

    public const DOCUMENT_TYPES = [
        'expense',
        'passive_credit_note',
        'passive_delivery_note',
    ];

    public function list(
        string $type,
        array $additionalData = []
    ): TaxesList|Error {
        $additionalData = array_merge($additionalData, [
            'type' => $type,
        ]);

        $additionalData = $this->data($additionalData, [
            'type', 'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/taxes',
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $taxesResponse = $response->data;

        return new TaxesList($taxesResponse);
    }

    public function all(
        string $type,
        array $additionalData = []
    ): array|Error {
        $additionalData = array_merge($additionalData, [
            'type' => $type,
        ]);

        $allDocuments = $this->getAll([
            'type', 'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ], 'c/'.$this->companyId.'/taxes', $additionalData);

        if ($allDocuments instanceof Error) {
            return $allDocuments;
        }

        return array_map(function ($document) {
            return new TaxesEntity($document);
        }, $allDocuments);
    }

    public function detail(
        int $documentId,
        array $additionalData = []
    ): TaxesEntity|Error {
        $additionalData = $this->data($additionalData, [
            'fields', 'fieldset',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/taxes/'.$documentId,
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $taxes = $response->data->data;

        return new TaxesEntity($taxes);
    }

    public function bin(
        int $documentId
    ): TaxesEntity|Error {
        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/bin/taxes/'.$documentId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $taxes = $response->data->data;

        return new TaxesEntity($taxes);
    }

    public function delete(
        int $documentId
    ): string|Error {
        /** @var object $response */
        $response = $this->destroy(
            'c/'.$this->companyId.'/taxes/'.$documentId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Tax document deleted';
    }

    /**
     * Create tax document. Body REQUIRED: data.type, data.entity.name, data.due_date (Y-m-d), data.amount, data.description.
     *
     * @param  array{data: array{type: string, entity: array{name: string}, due_date: string, amount: float, description: string}}  $body
     */
    public function create(
        array $body = []
    ): TaxesEntity|Error|MessageBag {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.type' => 'required|in:'.implode(',', self::DOCUMENT_TYPES),
            'data.entity.name' => 'required',
            'data.due_date' => 'required|date_format:'.self::DATE_FORMAT_YMD,
            'data.amount' => 'required|numeric',
            'data.description' => 'required',
        ], [
            'data.type.in' => 'The selected data.type is invalid. Select one between '.implode(', ', self::DOCUMENT_TYPES),
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $body = $this->normalizeBodyDate($body, 'data.due_date');

        /** @var object $response */
        $response = $this->post(
            'c/'.$this->companyId.'/taxes',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $taxes = $response->data->data;

        return new TaxesEntity($taxes);
    }

    public function edit(
        int $documentId,
        array $body = []
    ): TaxesEntity|Error|MessageBag {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.entity.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        if (isset($body['data']['due_date'])) {
            $body = $this->normalizeBodyDate($body, 'data.due_date');
        }

        /** @var object $response */
        $response = $this->put(
            'c/'.$this->companyId.'/taxes/'.$documentId,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $taxes = $response->data->data;

        return new TaxesEntity($taxes);
    }

    public function binDetail(
        int $documentId,
        array $additionalData = []
    ): TaxesEntity|Error {
        $document = $this->detail(
            $documentId,
            $additionalData
        );

        if ($document instanceof Error) {
            $document = $this->bin($documentId);

            if (
                ! $document instanceof Error
                && $document->type === 'proforma'
                && isset($document->merged_in)
            ) {
                $document = $this->detail(
                    $document->merged_in->id,
                    $additionalData
                );
            }
        }

        return $document;
    }

    public function attachment(
        array $body = []
    ): TaxesAttachment|Error|MessageBag {
        $validator = Validator::make($body, [
            'filename' => 'required',
            'attachment' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->post(
            'c/'.$this->companyId.'/taxes/attachment',
            $body,
            true
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $attachmentToken = $response->data->data;

        return new TaxesAttachment($attachmentToken);
    }

    public function deleteAttachment(
        int $documentId
    ): string|Error {
        /** @var object $response */
        $response = $this->destroy(
            'c/'.$this->companyId.'/taxes/'.$documentId.'/attachment'
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Attachment deleted';
    }
}
