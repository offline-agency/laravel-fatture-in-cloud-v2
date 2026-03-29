<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocument as ReceivedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentAttachment;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentPreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentTotals;
use OfflineAgency\LaravelFattureInCloudV2\Enums\ReceivedDocumentType;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class ReceivedDocument extends Api
{
    use ListTrait;

    /**
     * @deprecated Use ReceivedDocumentType enum instead.
     *
     * @var array<string>
     */
    public const DOCUMENT_TYPES = [
        'expense',
        'passive_credit_note',
        'passive_delivery_note',
    ];

    /**
     * @param  array<string, mixed>  $additionalData
     */
    public function list(
        ReceivedDocumentType|string $type,
        array $additionalData = []
    ): ReceivedDocumentList|Error {
        $typeValue = $type instanceof ReceivedDocumentType ? $type->value : $type;

        $additionalData = array_merge($additionalData, [
            'type' => $typeValue,
        ]);

        $additionalData = $this->data($additionalData, [
            'type', 'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ]);

        $response = $this->get(
            'c/'.$this->companyId.'/received_documents',
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receivedDocumentResponse = $response->data;

        return new ReceivedDocumentList($receivedDocumentResponse);
    }

    /**
     * @param  array<string, mixed>  $additionalData
     * @return array<ReceivedDocumentEntity>|Error
     */
    public function all(
        ReceivedDocumentType|string $type,
        array $additionalData = []
    ): array|Error {
        $typeValue = $type instanceof ReceivedDocumentType ? $type->value : $type;

        $additionalData = array_merge($additionalData, [
            'type' => $typeValue,
        ]);

        $allDocuments = $this->getAll([
            'type', 'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ], 'c/'.$this->companyId.'/received_documents', $additionalData);

        if ($allDocuments instanceof Error) {
            return $allDocuments;
        }

        return array_map(function ($document) {
            return new ReceivedDocumentEntity($document);
        }, $allDocuments);
    }

    /**
     * @param  array<string, mixed>  $additionalData
     */
    public function detail(
        int $documentId,
        array $additionalData = []
    ): ReceivedDocumentEntity|Error {
        $additionalData = $this->data($additionalData, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            'c/'.$this->companyId.'/received_documents/'.$documentId,
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receivedDocument = $response->data->data;

        return new ReceivedDocumentEntity($receivedDocument);
    }

    public function bin(
        int $documentId
    ): ReceivedDocumentEntity|Error {
        $response = $this->get(
            'c/'.$this->companyId.'/bin/received_documents/'.$documentId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receivedDocument = $response->data->data;

        return new ReceivedDocumentEntity($receivedDocument);
    }

    public function delete(
        int $documentId
    ): string|Error {
        $response = $this->destroy(
            'c/'.$this->companyId.'/received_documents/'.$documentId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Received document deleted';
    }

    /**
     * Create received document. Body REQUIRED: data.type, data.entity.name. Optional date fields (data.date, data.due_date) normalized to Y-m-d.
     *
     * @param  array{data?: array{type?: string, entity?: array{name?: string}, date?: string, due_date?: string}}  $body
     */
    public function create(
        array $body = []
    ): ReceivedDocumentEntity|Error|MessageBag {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.type' => 'required|in:'.implode(',', self::DOCUMENT_TYPES),
            'data.entity.name' => 'required',
        ], [
            'data.type.in' => 'The selected data.type is invalid. Select one between '.implode(', ', self::DOCUMENT_TYPES),
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $body = $this->normalizeBodyDate($body, 'data.date');
        $body = $this->normalizeBodyDate($body, 'data.due_date');

        $response = $this->post(
            'c/'.$this->companyId.'/received_documents',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receivedDocument = $response->data->data;

        return new ReceivedDocumentEntity($receivedDocument);
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function edit(
        int $documentId,
        array $body = []
    ): ReceivedDocumentEntity|Error|MessageBag {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.entity.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $body = $this->normalizeBodyDate($body, 'data.date');
        $body = $this->normalizeBodyDate($body, 'data.due_date');

        $response = $this->put(
            'c/'.$this->companyId.'/received_documents/'.$documentId,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receivedDocument = $response->data->data;

        return new ReceivedDocumentEntity($receivedDocument);
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function getNewTotals(
        array $body
    ): ReceivedDocumentTotals|Error|MessageBag {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.type' => 'required|in:'.implode(',', self::DOCUMENT_TYPES),
            'data.entity.name' => 'required',
        ], [
            'data.type.in' => 'The selected data.type is invalid. Select one between '.implode(', ', self::DOCUMENT_TYPES),
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->companyId.'/received_documents/totals',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receivedDocument = $response->data->data;

        return new ReceivedDocumentTotals($receivedDocument);
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function getExistingTotals(
        int $documentId,
        array $body = []
    ): ReceivedDocumentTotals|Error|MessageBag {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.entity.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->companyId.'/received_documents/'.$documentId.'/totals',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receivedDocument = $response->data->data;

        return new ReceivedDocumentTotals($receivedDocument);
    }

    public function preCreateInfo(
        string $type
    ): ReceivedDocumentPreCreateInfo|Error {
        $response = $this->get(
            'c/'.$this->companyId.'/received_documents/info',
            [
                'type' => $type,
            ]
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $info = $response->data->data;

        return new ReceivedDocumentPreCreateInfo($info);
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function attachment(
        array $body = []
    ): ReceivedDocumentAttachment|Error|MessageBag {
        $validator = Validator::make($body, [
            'filename' => 'required',
            'attachment' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->companyId.'/received_documents/attachment',
            $body,
            true
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $attachmentToken = $response->data->data;

        return new ReceivedDocumentAttachment($attachmentToken);
    }

    public function deleteAttachment(
        int $documentId
    ): string|Error {
        $response = $this->destroy(
            'c/'.$this->companyId.'/received_documents/'.$documentId.'/attachment'
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Attachment deleted';
    }

    /**
     * @param  array<string, mixed>  $additionalData
     */
    public function binDetail(
        int $documentId,
        array $additionalData = []
    ): ReceivedDocumentEntity|Error {
        $document = $this->detail(
            $documentId,
            $additionalData
        );

        if ($document instanceof Error) {
            $document = $this->bin($documentId);

            if (
                ! $document instanceof Error
                && $document->type === 'proforma'
                && is_object($document->merged_in)
                && isset($document->merged_in->id)
                && is_int($document->merged_in->id)
            ) {
                $document = $this->detail(
                    $document->merged_in->id,
                    $additionalData
                );
            }
        }

        return $document;
    }
}
