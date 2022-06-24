<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\Attachment;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\Document;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\DocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\Email;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\PreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\ScheduleEmail;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\Total;

class IssuedDocumentFakeResponse extends FakeResponse
{
    public function getIssuedDocumentsFakeList(
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

    public function getEmptyIssuedDocumentsFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getIssuedDocumentFakeDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Document())->getIssuedDocumentFakeDetail($params),
        ]);
    }

    public function getIssuedDocumentFakeTotals(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Total())->getTotalFake($params),
        ]);
    }

    public function getIssuedDocumentFakePreCreateInfo(
        array $params = []
    ) {
        return json_encode([
            'data' => (new PreCreateInfo())->getPreCreateInfoFake($params),
        ]);
    }

    public function getIssuedDocumentFakEmailData(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Email())->getEmailFake($params),
        ]);
    }

    public function getIssuedDocumentFakScheduleEmail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new ScheduleEmail())->getEmailFake($params),
        ]);
    }

    public function getIssuedDocumentFakScheduleAttachment(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Attachment())->getAttachmentFake($params),
        ]);
    }

    public function getIssuedDocumentFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }

    public function getIssuedDocumentFakeErrorDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new ErrorFakeResponse())->getErrorFake($params),
        ]);
    }
}
