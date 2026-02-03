<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocument as ReceivedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentTotals;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentAttachment;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentPreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class ReceivedDocument extends Api
{
    use ListTrait;

    const DOCUMENT_TYPES = [
        'expense',
        'passive_credit_note',
        'passive_delivery_note'
    ];

    public function list(
        string $type,
        ?array $additional_data = []
    )
    {
        $additional_data = array_merge($additional_data, [
            'type' => $type,
        ]);

        $additional_data = $this->data($additional_data, [
            'type', 'fields', 'fieldset', 'sort', 'page', 'per_page', 'q'
        ]);

        $response = $this->get(
            'c/' . $this->company_id . 'received_documents',
            $additional_data
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $received_document_response = $response->data;

        return new ReceivedDocumentList($received_document_response);
    }

    public function all(
        string $type,
        ?array $additional_data = []
    ) {
        $additional_data = array_merge($additional_data, [
            'type' => $type,
        ]);

        $all_documents = $this->getAll([
            'type', 'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ], 'c/'.$this->company_id.'/received_documents', $additional_data);

        return gettype($all_documents) !== 'array'
            ? $all_documents
            : array_map(function($document) {
                return new ReceivedDocumentEntity($document);
            }, $all_documents);
    }

    public function detail(
        int $document_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            'c/'.$this->company_id.'/received_documents/'.$document_id,
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $received_document = $response->data->data;

        return new ReceivedDocumentEntity($received_document);
    }

    public function bin(
        int $document_id
    ) {
        $response = $this->get(
            'c/'.$this->company_id.'/bin/received_documents/'.$document_id
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $received_document = $response->data->data;

        return new ReceivedDocumentEntity($received_document);
    }

    public function delete(
        int $document_id
    ) {
        $response = $this->destroy(
            'c/'.$this->company_id.'/received_documents/'.$document_id
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
            'data.type' => 'required|in:'.implode(',', ReceivedDocument::DOCUMENT_TYPES),
            'data.entity.name' => 'required',
        ], [
            'data.type.in' => 'The selected data.type is invalid. Select one between '.implode(', ', ReceivedDocument::DOCUMENT_TYPES),
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->company_id.'/received_documents',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $received_document = $response->data->data;

        return new ReceivedDocumentEntity($received_document);
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
            'c/'.$this->company_id.'/received_documents/'.$document_id,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $received_document = $response->data->data;

        return new ReceivedDocumentEntity($received_document);
    }

    public function getNewTotals(
        array $body
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.type' => 'required|in:'.implode(',', ReceivedDocument::DOCUMENT_TYPES),
            'data.entity.name' => 'required',
        ], [
            'data.type.in' => 'The selected data.type is invalid. Select one between '.implode(', ', ReceivedDocument::DOCUMENT_TYPES),
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->company_id.'/received_documents/totals',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $received_document = $response->data->data;

        return new ReceivedDocumentTotals($received_document);
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

        $response = $this->post(
            'c/'.$this->company_id.'/received_documents/'.$document_id.'/totals',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $received_document = $response->data->data;

        return new ReceivedDocumentTotals($received_document);
    }

    public function preCreateInfo(
        string $type
    ) {
        $response = $this->get(
            'c/'.$this->company_id.'/received_documents/info',
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
    ) {
        $validator = Validator::make($body, [
            'filename' => 'required',
            'attachment' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->company_id.'/received_documents/attachment',
            $body,
            true
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $attachment_token = $response->data->data;

            return new ReceivedDocumentAttachment($attachment_token);
    }

    public function deleteAttachment(
        int $document_id
    ) {
        $response = $this->destroy(
            'c/'.$this->company_id.'/received_documents/'.$document_id.'/attachment'
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Attachment deleted';
    }

    public function binDetail(
        int $document_id,
        ?array $additional_data = []
    ) {
        $document = $this->detail(
            $document_id,
            $additional_data
        );

        if ($document instanceof Error) {
            $document = $this->bin($document_id);

            if (
                ! $document instanceof Error
                && $document->type === 'proforma'
                && ! is_null($document->merged_in)
            ) {
                $document = $this->detail(
                    $document->merged_in->id,
                    $additional_data
                );
            }
        }

        return $document;
    }
}
