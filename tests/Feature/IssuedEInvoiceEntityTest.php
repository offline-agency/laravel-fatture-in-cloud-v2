<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedEInvoice;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoice as IssuedEInvoiceEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoiceVerifyXML;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class IssuedEInvoiceEntityTest extends TestCase
{
    //TODO: create fake response

    // send

    public function test_send_issued_e_invoice()
    {
        $document_id = 214696238;

        $issued_e_invoices = new IssuedEInvoice();
        $response = $issued_e_invoices->send($document_id);

        //$this->assertInstanceOf(IssuedEInvoiceEntity::class, $response);
    }

    // verify XML

    public function test_verify_xml_e_invoice()
    {
        $document_id = 214696238;

        $issued_e_invoices = new IssuedEInvoice();
        $response = $issued_e_invoices->verifyXML($document_id);

        //$this->assertInstanceOf(Error::class, $response);
        //$this->assertInstanceOf(IssuedEInvoiceVerifyXML::class, $response);
    }

    // get XML

    public function test_get_xml_e_invoice()
    {
        $document_id = 214696238;

        $issued_e_invoices = new IssuedEInvoice();
        $response = $issued_e_invoices->getXML($document_id);

        //TODO: fix response

        dd($response);
    }

    // get rejection reason

    public function test_get_rejection_reason_e_invoice()
    {
        $document_id = 214696238;

        $issued_e_invoices = new IssuedEInvoice();
        $response = $issued_e_invoices->getRejectionReason($document_id);

        //TODO: fix response

        dd($response);

        //$this->assertInstanceOf(Error::class, $response);
        //$this->assertInstanceOf(IssuedEInvoiceVerifyXML::class, $response);
    }
}
