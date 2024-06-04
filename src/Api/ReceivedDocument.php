<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocument as ReceivedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentList;

class ReceivedDocument extends Api
{
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

    public function delete(
        int $document_id
    ) {
       $response = $this->destroy(
           'c/'.$this->company_id.'/received_document/'.$document_id
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
            'c/'.$this->company_id.'/received_document/'.$document_id,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $received_document = $response->data->data;

        return new ReceivedDocumentEntity($received_document);
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
            'c/'.$this->company_id.'/Received_documents/totals',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $received_document = $response->data->data;

        return new ReceivedDocumentEntity($received_document);
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
            'c/' . $this->company_id . '/Received_documents/'.$document_id.'/totals',
            $body
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $received_document = $response->data->data;

        return new ReceivedDocumentEntity($received_document);
    }

    public function uploadAttachment(
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
            'c/' . $this->company_id . '/received_documents/attachment',
            $body,
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $attachment_token = $response->data->data;

        return new ReceivedDocumentEntity($attachment_token);
    }

    public function getPreCreateInfo(
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

        $infoReceivedDocuments = $response->data->data;

        return new ReceivedDocumentEntity($infoReceivedDocuments);
    }
}
