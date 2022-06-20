<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocument as IssuedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentAttachment;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentEmail;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentPreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentScheduleEmail;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentTotals;

class IssuedDocument extends Api
{
    const DOCUMENT_TYPES = [
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

    public function list(
        string $type,
        ?array $additional_data = []
    ) {
        $additional_data = array_merge($additional_data, [
            'type' => $type,
        ]);

        $additional_data = $this->data($additional_data, [
            'type', 'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ]);

        $response = $this->get(
            $this->company_id.'/issued_documents',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $issued_document_response = $response->data;

        return new IssuedDocumentList($issued_document_response);
    }

    public function detail(
        int $document_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            $this->company_id.'/issued_documents/'.$document_id,
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $issued_document = $response->data->data;

        return new IssuedDocumentEntity($issued_document);
    }

    public function bin(
        int $document_id
    ) {
        $response = $this->get(
            $this->company_id.'/bin/issued_documents/'.$document_id
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $issued_document = $response->data->data;

        return new IssuedDocumentEntity($issued_document);
    }

    public function delete(
        int $document_id
    ) {
        $response = $this->destroy(
            $this->company_id.'/issued_documents/'.$document_id
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Document deleted';
    }

    public function create(
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.type' => 'required|in:'.implode(',', IssuedDocument::DOCUMENT_TYPES),
            'data.entity.name' => 'required',
        ], [
            'data.type.in' => 'The selected data.type is invalid. Select one between '.implode(', ', IssuedDocument::DOCUMENT_TYPES),
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            $this->company_id.'/issued_documents',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $issued_document = $response->data->data;

        return new IssuedDocumentEntity($issued_document);
    }

    public function edit(
        int $document_id,
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.entity.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            $this->company_id.'/issued_documents/'.$document_id,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $issued_document = $response->data->data;

        return new IssuedDocumentEntity($issued_document);
    }

    public function getNewTotals(
        array $body
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.type' => 'required|in:'.implode(',', IssuedDocument::DOCUMENT_TYPES),
            'data.entity.name' => 'required',
        ], [
            'data.type.in' => 'The selected data.type is invalid. Select one between '.implode(', ', IssuedDocument::DOCUMENT_TYPES),
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            $this->company_id.'/issued_documents/totals',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $issued_document = $response->data->data;

        return new IssuedDocumentTotals($issued_document);
    }

    public function getExistingTotals(
        int $document_id,
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.entity.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            $this->company_id.'/issued_documents/'.$document_id.'/totals',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $issued_document = $response->data->data;

        return new IssuedDocumentTotals($issued_document);
    }

    public function preCreateInfo(
        string $type
    ) {
        $response = $this->get(
            $this->company_id.'/issued_documents/info',
            [
                'type' => $type,
            ]
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $info = $response->data->data;

        return new IssuedDocumentPreCreateInfo($info);
    }

    public function emailData(
        int $document_id
    ) {
        $response = $this->get(
            $this->company_id.'/issued_documents/'.$document_id.'/email'
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $email = $response->data->data;

        return new IssuedDocumentEmail($email);
    }

    public function attachment(
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'filename' => 'required',
            'attachment' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            $this->company_id.'/issued_documents/attachment',
            $body,
            true
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $attachment_token = $response->data->data;

        return new IssuedDocumentAttachment($attachment_token);
    }

    public function deleteAttachment(
        int $document_id
    ) {
        $response = $this->destroy(
            $this->company_id.'/issued_documents/'.$document_id.'/attachment'
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Attachment deleted';
    }

    public function scheduleEmail(
        int $document_id,
        array $body = []
    ) {
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

        $response = $this->post(
            $this->company_id.'/issued_documents/'.$document_id.'/email',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $schedule_email = $response->data->data;

        return new IssuedDocumentScheduleEmail($schedule_email);
    }
}
