<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class TaxesAttachment extends AbstractEntity
{
    use CastsFromMixed;

    public string $attachment_token;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->attachment_token = self::nullableString($parameters, 'attachment_token') ?? '';
    }
}
