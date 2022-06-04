<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument as IssuedDocumentEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Document\IssuedDocument as SingleIssuedDocumentEntity;

class IssuedDocument extends Api
{
    public function list(
        int    $company_id,
        string $type,
        ?array $additional_data = []
    )
    {
        $additional_data = array_merge($additional_data, [
            'type' => $type,
        ]);

        $additional_data = $this->data($additional_data, [
            'type', 'fields', 'fieldset', 'sort', 'page', 'per_page',
        ]);

        $response = $this->get(
            $company_id . '/issued_documents',
            $additional_data
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $issued_documents = $response->data;

        return array_map(function ($document) {
            return new IssuedDocumentEntity($document);
        }, $issued_documents->data);
    }

    public function detail(
        int    $company_id,
        int    $document_id,
        ?array $additional_data = []
    )
    {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset'
        ]);

        $response = $this->get(
            $company_id . '/issued_documents/' . $document_id,
            $additional_data
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $issued_document = $response->data->data;

        return new SingleIssuedDocumentEntity($issued_document);
    }
}
