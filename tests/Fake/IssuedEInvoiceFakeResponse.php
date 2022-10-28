<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedEInvoice\IssuedEInvoice;

class IssuedEInvoiceFakeResponse extends FakeResponse
{
    public function getIssuedEInvoiceFakeSend(
        array $params = []
    ) {
        return json_encode([
            'data' => (new IssuedEInvoice())->getIssuedEInvoiceFakeSend($params),
        ]);
    }

    public function getIssuedEInvoiceFakeVerifyXML(
        array $params = []
    ) {
        return json_encode([
            'data' => (new IssuedEInvoice())->getIssuedEInvoiceFakeVerifyXML($params),
        ]);
    }

    public function getIssuedEInvoiceFakeRejectionReason(
        array $params = []
    ) {
        return json_encode([
            'data' => (new IssuedEInvoice())->getIssuedEInvoiceFakeRejectionReason($params),
        ]);
    }

    public function getIssuedEInvoiceFakeGetXML(
        array $params = []
    ) {
        return json_encode((new IssuedEInvoice())->getIssuedEInvoiceFakeGetXML($params));
    }

    public function getIssuedEInvoiceFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }
}
