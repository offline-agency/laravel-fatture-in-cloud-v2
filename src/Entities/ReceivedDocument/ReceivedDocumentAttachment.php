<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

readonly class ReceivedDocumentAttachment extends AbstractEntity
{
    public string $attachment_token;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->attachment_token = (string) ($parameters['attachment_token'] ?? '');
    }
}
