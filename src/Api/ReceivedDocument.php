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
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class ReceivedDocument extends Api
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
    ): ReceivedDocumentList|Error {
        $additionalData = array_merge($additionalData, [
            'type' => $type,
        ]);

        $additionalData = $this->data($additionalData, [
            'type', 'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ]);

        /** @var object $response */
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

    public function all(
        string $type,
        array $additionalData = []
    ): array|Error {
        $additionalData = array_merge($additionalData, [
            'type' => $type,
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

    public function detail(
        int $documentId,
        array $additionalData = []
    ): ReceivedDocumentEntity|Error {
        $additionalData = $this->data($additionalData, [
            'fields', 'fieldset',
        ]);

        /** @var object $response */
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
        /** @var object $response */
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
        /** @var object $response */
        $response = $this->destroy(
            'c/'.$this->companyId.'/received_documents/'.$documentId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Document deleted';
    }

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

        /** @var object $response */
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

        /** @var object $response */
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

        /** @var object $response */
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

        /** @var object $response */
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
        /** @var object $response */
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

        /** @var object $response */
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
        /** @var object $response */
        $response = $this->destroy(
            'c/'.$this->companyId.'/received_documents/'.$documentId.'/attachment'
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Attachment deleted';
    }

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
}
