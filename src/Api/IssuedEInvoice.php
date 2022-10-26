<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoiceRejectionReason;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoiceVerifyXML;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoice as IssuedEInvoiceEntity;

class IssuedEInvoice extends Api
{
    use ListTrait;

    public function send(
        int   $document_id,
        array $body = []
    )
    {
        $response = $this->post(
            'c/'.$this->company_id.'/issued_documents/'.$document_id.'/e_invoice/send',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $issued_e_invoice = $response->data->data;

        return new IssuedEInvoiceEntity($issued_e_invoice);
    }

    public function verifyXML(
        int   $document_id
    )
    {
        $response = $this->get(
            'c/'.$this->company_id.'/issued_documents/'.$document_id.'/e_invoice/xml_verify',
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipts = $response->data->data;

        return new IssuedEInvoiceVerifyXML($receipts);
    }

    public function getXML(
        int   $document_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'include_attachment'
        ]);

        $response = $this->get(
            'c/'.$this->company_id.'/issued_documents/'.$document_id.'/e_invoice/xml',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        dd($response);

        $issued_document_response = $response->data;

        return $issued_document_response;
    }

    public function getRejectionReason(
        int   $document_id
    )
    {
        $response = $this->get(
            'c/'.$this->company_id.'/issued_documents/'.$document_id.'/e_invoice/error_reason',
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipts = $response->data->data;

        return new IssuedEInvoiceRejectionReason($receipts);
    }

}
