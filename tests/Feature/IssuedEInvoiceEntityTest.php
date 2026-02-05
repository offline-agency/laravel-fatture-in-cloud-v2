<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedEInvoice;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoiceRejectionReason;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoiceSend;
use OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice\IssuedEInvoiceVerifyXML;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedEInvoiceFakeResponse;

describe('Issued E-Invoice Entity', function () {
    it('sends an issued e-invoice', function () {
        $documentId = 1;

        Http::fake([
            '*/issued_documents/'.$documentId.'/e_invoice/send' => Http::response(
                (new IssuedEInvoiceFakeResponse())->getIssuedEInvoiceFakeSend()
            ),
        ]);

        $api = new IssuedEInvoice();
        $response = $api->send($documentId);

        expect($response)->toBeInstanceOf(IssuedEInvoiceSend::class);
    });

    it('handles error on e-invoice send', function () {
        $documentId = 1;

        Http::fake([
            '*/issued_documents/'.$documentId.'/e_invoice/send' => Http::response(
                (new IssuedEInvoiceFakeResponse())->getIssuedEInvoiceFakeError(),
                401
            ),
        ]);

        $api = new IssuedEInvoice();
        $response = $api->send($documentId);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('verifies e-invoice XML', function () {
        $documentId = 1;

        Http::fake([
            '*/issued_documents/'.$documentId.'/e_invoice/xml_verify' => Http::response(
                (new IssuedEInvoiceFakeResponse())->getIssuedEInvoiceFakeVerifyXML()
            ),
        ]);

        $api = new IssuedEInvoice();
        $response = $api->verifyXML($documentId);

        expect($response)->toBeInstanceOf(IssuedEInvoiceVerifyXML::class);
    });

    it('gets e-invoice XML', function () {
        $documentId = 1;

        Http::fake([
            '*/issued_documents/'.$documentId.'/e_invoice/xml' => Http::response(
                (new IssuedEInvoiceFakeResponse())->getIssuedEInvoiceFakeGetXML()
            ),
        ]);

        $api = new IssuedEInvoice();
        $response = $api->getXML($documentId);

        expect($response)->not->toBeNull();
    });

    it('gets rejection reason', function () {
        $documentId = 1;

        Http::fake([
            '*/issued_documents/'.$documentId.'/e_invoice/error_reason' => Http::response(
                (new IssuedEInvoiceFakeResponse())->getIssuedEInvoiceFakeRejectionReason()
            ),
        ]);

        $api = new IssuedEInvoice();
        $response = $api->getRejectionReason($documentId);

        expect($response)->toBeInstanceOf(IssuedEInvoiceRejectionReason::class);
    });
});
