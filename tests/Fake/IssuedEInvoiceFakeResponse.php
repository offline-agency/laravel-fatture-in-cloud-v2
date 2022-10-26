<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\Attachment;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\Document;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\DocumentList;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\Email;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\PreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\ScheduleEmail;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\Total;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedEInvoice\SingleIssuedEInvoice;

class IssuedEInvoiceFakeResponse extends FakeResponse
{
    public function getIssuedEInvoiceFakeDetail(
        array $params = []
    ) {
        return json_encode([
                'data' => [
                    (new SingleIssuedEInvoice())->getVatTypeFakeDetail($params),
                ],
            ]);
    }
}
