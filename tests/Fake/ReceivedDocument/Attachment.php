<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Attachment extends FakeResponse
{
    public function getAttachmentFake(
        array $params = []
    ): array {
        return [
            'attachment_token' => $this->value($params, 'attachment_token', 'fake_attachment_token'),
        ];
    }
}
