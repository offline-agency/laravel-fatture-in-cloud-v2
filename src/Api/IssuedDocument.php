<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocument as IssuedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentList;

class IssuedDocument extends Api
{
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
}
