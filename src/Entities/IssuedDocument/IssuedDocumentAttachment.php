<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

readonly class IssuedDocumentAttachment
{
    public ?string $attachmentToken;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->attachmentToken = $parameters['attachment_token'] ?? null;
    }
}
