<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedEInvoice;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoiceRejectionReason;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoiceSend;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoiceVerifyXML;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedEInvoiceFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceiptFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class IssuedEInvoiceEntityTest extends TestCase
{
    // send

    public function test_send_issued_e_invoice()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id.'/e_invoice/send' => Http::response(
                (new IssuedEInvoiceFakeResponse())->getIssuedEInvoiceFakeSend()
            ),
        ]);

        $issued_e_invoices = new IssuedEInvoice();
        $response = $issued_e_invoices->send($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedEInvoiceSend::class, $response);
    }

    public function test_error_on_send_issued_e_invoice()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id.'/e_invoice/send' => Http::response(
                (new IssuedEInvoiceFakeResponse())->getIssuedEInvoiceFakeError(),
                401
            ),
        ]);

        $issued_e_invoices = new IssuedEInvoice();
        $response = $issued_e_invoices->send($document_id);

        $this->assertInstanceOf(Error::class, $response);
    }

    // verify XML

    public function test_verify_xml_e_invoice()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id.'/e_invoice/xml_verify' => Http::response(
                (new IssuedEInvoiceFakeResponse())->getIssuedEInvoiceFakeVerifyXML()
            ),
        ]);

        $issued_e_invoices = new IssuedEInvoice();
        $response = $issued_e_invoices->verifyXML($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedEInvoiceVerifyXML::class, $response);
    }

    public function test_error_on_verify_xml_e_invoice()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id.'/e_invoice/xml_verify' => Http::response(
                (new IssuedEInvoiceFakeResponse())->getIssuedEInvoiceFakeVerifyXML(),
                401
            ),
        ]);

        $issued_e_invoices = new IssuedEInvoice();
        $response = $issued_e_invoices->verifyXML($document_id);

        $this->assertInstanceOf(Error::class, $response);
    }

    // get XML

    public function test_get_xml_e_invoice()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id.'/e_invoice/xml' => Http::response(
                (new IssuedEInvoiceFakeResponse())->getIssuedEInvoiceFakeGetXML()
            ),
        ]);

        $issued_e_invoices = new IssuedEInvoice();
        $response = $issued_e_invoices->getXML($document_id);

        $this->assertNotNull($response);
    }

    public function test_error_on_get_xml_e_invoice()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id.'/e_invoice/xml' => Http::response(
                (new IssuedEInvoiceFakeResponse())->getIssuedEInvoiceFakeError(),
                401
            ),
        ]);

        $issued_e_invoices = new IssuedEInvoice();
        $response = $issued_e_invoices->getXML($document_id);

        $this->assertInstanceOf(Error::class, $response);
    }

    // get rejection reason

    public function test_get_rejection_reason_e_invoice()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id.'/e_invoice/error_reason' => Http::response(
                (new IssuedEInvoiceFakeResponse())->getIssuedEInvoiceFakeRejectionReason()
            ),
        ]);

        $issued_e_invoices = new IssuedEInvoice();
        $response = $issued_e_invoices->getRejectionReason($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(IssuedEInvoiceRejectionReason::class, $response);
    }

    public function test_error_on_get_rejection_reason_e_invoice()
    {
        $document_id = 1;

        Http::fake([
            'issued_documents/'.$document_id.'/e_invoice/error_reason' => Http::response(
                (new IssuedEInvoiceFakeResponse())->getIssuedEInvoiceFakeRejectionReason(),
                401
            ),
        ]);

        $issued_e_invoices = new IssuedEInvoice();
        $response = $issued_e_invoices->getRejectionReason($document_id);

        $this->assertInstanceOf(Error::class, $response);
    }
}
