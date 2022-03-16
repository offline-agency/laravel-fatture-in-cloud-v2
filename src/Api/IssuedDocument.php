<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument as IssuedDocumentEntity;

class IssuedDocument extends Api
{
    public function list(
        string $company_id,
        string $type,
        ?array $additional_data = []
    ) {
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

        if (! $response->success) {
            return new Error($response->data);
        }

        $issued_documents = $response->data;

        return array_map(function ($document) {
            return new IssuedDocumentEntity($document);
        }, $issued_documents->data);
    }
}
