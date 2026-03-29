<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class TaxesCreate extends AbstractEntity
{
    use CastsFromMixed;

    public ?string $attachmentToken;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->attachmentToken = self::nullableString($parameters, 'attachment_token');
    }
}
