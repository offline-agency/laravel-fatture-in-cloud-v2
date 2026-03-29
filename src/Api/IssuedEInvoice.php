<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoiceRejectionReason;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoiceSend;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoiceVerifyXML;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class IssuedEInvoice extends Api
{
    use ListTrait;

    /**
     * @param  array<string, mixed>  $body
     */
    public function send(int $documentId, array $body = []): IssuedEInvoiceSend|Error
    {
        $response = $this->post(
            'c/'.$this->companyId.'/issued_documents/'.$documentId.'/e_invoice/send',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $issuedEInvoice = $response->data->data;

        return new IssuedEInvoiceSend($issuedEInvoice);
    }

    public function verifyXML(int $documentId): IssuedEInvoiceVerifyXML|Error
    {
        $response = $this->get(
            'c/'.$this->companyId.'/issued_documents/'.$documentId.'/e_invoice/xml_verify',
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipts = $response->data->data;

        return new IssuedEInvoiceVerifyXML($receipts);
    }

    /** @return object|Error */
    /**
     * @param  array<string, mixed>  $additionalData
     */
    public function getXML(int $documentId, array $additionalData = []): object
    {
        $additionalData = $this->data($additionalData, [
            'include_attachment',
        ]);

        $response = $this->get(
            'c/'.$this->companyId.'/issued_documents/'.$documentId.'/e_invoice/xml',
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return $response;
    }

    public function getRejectionReason(int $documentId): IssuedEInvoiceRejectionReason|Error
    {
        $response = $this->get(
            'c/'.$this->companyId.'/issued_documents/'.$documentId.'/e_invoice/error_reason',
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $receipts = $response->data->data;

        return new IssuedEInvoiceRejectionReason($receipts);
    }
}
