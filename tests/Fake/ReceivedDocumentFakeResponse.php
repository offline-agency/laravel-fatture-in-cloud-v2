<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Attachment;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Document;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\DocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Email;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\PreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\ScheduleEmail;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument\Total;

class ReceivedDocumentFakeResponse extends FakeResponse
{
    public function getReceivedDocumentsFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new DocumentList())->getListDocumentFake($params),
                    (new DocumentList())->getListDocumentFake($params),
                ],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getReceivedDocumentsFakeAll(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new DocumentList())->getListDocumentFake($params),
                    (new DocumentList())->getListDocumentFake($params),
                ],
            ]
        ));
    }

    public function getEmptyReceivedDocumentsFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getReceivedDocumentFakeDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Document())->getReceivedDocumentFakeDetail($params),
        ]);
    }

    public function getReceivedDocumentFakeTotals(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Total())->getTotalFake($params),
        ]);
    }

    public function getReceivedDocumentFakePreCreateInfo(
        array $params = []
    ) {
        return json_encode([
            'data' => (new PreCreateInfo())->getPreCreateInfoFake($params),
        ]);
    }

    public function getReceivedDocumentFakEmailData(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Email())->getEmailFake($params),
        ]);
    }

    public function getReceivedDocumentFakScheduleEmail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new ScheduleEmail())->getEmailFake($params),
        ]);
    }

    public function getReceivedDocumentFakScheduleAttachment(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Attachment())->getAttachmentFake($params),
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
