<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class IssuedDocumentAttachment
{
    use CastsFromMixed;

    public ?string $attachmentToken;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->attachmentToken = self::nullableString($parameters, 'attachment_token');
    }
}
