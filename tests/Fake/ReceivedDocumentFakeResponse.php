<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Currencies;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\ItemsValues;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Values;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Document;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Vat;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Payment;

class ReceivedDocumentFakeResponse extends FakeResponse
{
    public function getReceivedDocumentFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new Document)->getIssuedDocumentFakeDetail($params),
                    (new Document())->getIssuedDocumentFakeDetail($params),
                ],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getReceivedDocumentFakeAll(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new Document)->getIssuedDocumentFakeDetail($params),
                    (new Document)->getIssuedDocumentFakeDetail($params),
                ],
            ]
        ));
    }

    public function getEmptyReceivedDocumentFakeList(
        array $params = []
    )
    {
        return json_encode(array_merge(
            [
                'data' => [],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getReceivedDocumentFakeValues(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Values())->getValuesFake($params),
        ]);
    }

    public function getReceivedDocumentFakeVat(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Vat())->getVatFake($params),
        ]);
    }

    public function getReceivedDocumentFakePayment(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Payment)->getPaymentFake($params),
        ]);
    }

    public function getReceivedDocumentFakeItemValues(
        array $params = []
    ) {
        return json_encode([
            'data' => (new ItemsValues)->getItemsValuesFake($params),
        ]);
    }

    public function getReceivedDocumentFakeCurrencies(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Currencies)->getCurrenciesFake($params),
        ]);
    }

    public function getReceivedDocumentFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }

    public function getReceivedDocumentFakeErrorDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new ErrorFakeResponse())->getErrorFake($params),
        ]);
    }
}
