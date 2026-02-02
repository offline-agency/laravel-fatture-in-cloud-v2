<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocument as IssuedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentAttachment;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentEmail;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentPreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentScheduleEmail;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentTotals;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class IssuedDocument extends Api
{
    use ListTrait;

    const array DOCUMENT_TYPES = [
        'invoice',
        'quote',
        'proforma',
        'receipt',
        'delivery_note',
        'credit_note',
        'order',
        'work_report',
        'supplier_order',
        'self_own_invoice',
        'self_supplier_invoice',
    ];

    public function list(string $type, array $additionalData = []): IssuedDocumentList|Error
    {
        $additionalData = array_merge($additionalData, [
            'type' => $type,
        ]);

        $additionalData = $this->data($additionalData, [
            'type',
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/' . $this->companyId . '/issued_documents',
            $additionalData
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $issuedDocumentResponse = $response->data;

        return new IssuedDocumentList($issuedDocumentResponse);
    }

    /**
     * @return array<IssuedDocumentEntity>|Error
     */
    public function all(string $type, array $additionalData = []): array|Error
    {
        $additionalData = array_merge($additionalData, [
            'type' => $type,
        ]);

        $allDocuments = $this->getAll([
            'type',
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
        ], 'c/' . $this->companyId . '/issued_documents', $additionalData);

        if ($allDocuments instanceof Error) {
            return $allDocuments;
        }

        return array_map(function ($document) {
            return new IssuedDocumentEntity($document);
        }, $allDocuments);
    }

    public function detail(int $documentId, array $additionalData = []): IssuedDocumentEntity|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/' . $this->companyId . '/issued_documents/' . $documentId,
            $additionalData
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $issuedDocument = $response->data->data;

        return new IssuedDocumentEntity($issuedDocument);
    }

    public function bin(int $documentId): IssuedDocumentEntity|Error
    {
        /** @var object $response */
        $response = $this->get(
            'c/' . $this->companyId . '/bin/issued_documents/' . $documentId
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $issuedDocument = $response->data->data;

        return new IssuedDocumentEntity($issuedDocument);
    }

    public function delete(int $documentId): string|Error
    {
        /** @var object $response */
        $response = $this->destroy(
            'c/' . $this->companyId . '/issued_documents/' . $documentId
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        return 'Document deleted';
    }

    public function create(array $body = []): IssuedDocumentEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.type' => 'required|in:' . implode(',', self::DOCUMENT_TYPES),
            'data.entity.name' => 'required',
        ], [
            'data.type.in' => 'The selected data.type is invalid. Select one between ' . implode(', ', self::DOCUMENT_TYPES),
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->post(
            'c/' . $this->companyId . '/issued_documents',
            $body
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $issuedDocument = $response->data->data;

        return new IssuedDocumentEntity($issuedDocument);
    }

    public function edit(int $documentId, array $body = []): IssuedDocumentEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.entity.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->put(
            'c/' . $this->companyId . '/issued_documents/' . $documentId,
            $body
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $issuedDocument = $response->data->data;

        return new IssuedDocumentEntity($issuedDocument);
    }

    public function getNewTotals(array $body): IssuedDocumentTotals|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.type' => 'required|in:' . implode(',', self::DOCUMENT_TYPES),
            'data.entity.name' => 'required',
        ], [
            'data.type.in' => 'The selected data.type is invalid. Select one between ' . implode(', ', self::DOCUMENT_TYPES),
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->post(
            'c/' . $this->companyId . '/issued_documents/totals',
            $body
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $issuedDocument = $response->data->data;

        return new IssuedDocumentTotals($issuedDocument);
    }

    public function getExistingTotals(int $documentId, array $body = []): IssuedDocumentTotals|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.entity.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->put(
            'c/' . $this->companyId . '/issued_documents/' . $documentId . '/totals',
            $body
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $issuedDocument = $response->data->data;

        return new IssuedDocumentTotals($issuedDocument);
    }

    public function preCreateInfo(string $type): IssuedDocumentPreCreateInfo|Error
    {
        /** @var object $response */
        $response = $this->get(
            'c/' . $this->companyId . '/issued_documents/info',
            [
                'type' => $type,
            ]
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $info = $response->data->data;

        return new IssuedDocumentPreCreateInfo($info);
    }

    public function emailData(int $documentId): IssuedDocumentEmail|Error
    {
        /** @var object $response */
        $response = $this->get(
            'c/' . $this->companyId . '/issued_documents/' . $documentId . '/email'
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $email = $response->data->data;

        return new IssuedDocumentEmail($email);
    }

    public function attachment(array $body = []): IssuedDocumentAttachment|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'filename' => 'required',
            'attachment' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->post(
            'c/' . $this->companyId . '/issued_documents/attachment',
            $body,
            true
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $attachmentToken = $response->data->data;

        return new IssuedDocumentAttachment($attachmentToken);
    }

    public function deleteAttachment(int $documentId): string|Error
    {
        /** @var object $response */
        $response = $this->destroy(
            'c/' . $this->companyId . '/issued_documents/' . $documentId . '/attachment'
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        return 'Attachment deleted';
    }

    public function scheduleEmail(int $documentId, array $body = []): IssuedDocumentScheduleEmail|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.sender_id' => 'required_without:data.sender_email',
            'data.sender_email' => 'required_without:data.sender_id',
            'data.recipient_email' => 'required',
            'data.subject' => 'required',
            'data.body' => 'required',
            'data.include' => 'required',
            'data.include.document' => 'required',
            'data.include.delivery_note' => 'required',
            'data.include.attachment' => 'required',
            'data.include.accompanying_invoice' => 'required',
            'data.attach_pdf' => 'required',
            'data.send_copy' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->post(
            'c/' . $this->companyId . '/issued_documents/' . $documentId . '/email',
            $body
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $scheduleEmail = $response->data->data;

        return new IssuedDocumentScheduleEmail($scheduleEmail);
    }

    public function binDetail(int $documentId, array $additionalData = []): IssuedDocumentEntity|Error
    {
        $document = $this->detail($documentId, $additionalData);

        if ($document instanceof Error) {
            $document = $this->bin($documentId);

            if (
                !$document instanceof Error
                && isset($document->type)
                && $document->type === 'proforma'
                && isset($document->merged_in)
                && !is_null($document->merged_in)
            ) {
                // Fixed accessing property on object
                $mergedIn = $document->merged_in;
                if (!is_object($mergedIn) || !isset($mergedIn->id)) {
                    return $document;
                }

                $id = (int) $mergedIn->id;

                $document = $this->detail(
                    $id,
                    $additionalData
                );
            }
        }

        return $document;
    }
}
