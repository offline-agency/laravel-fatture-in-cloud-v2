<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class IssuedDocumentScheduleEmail
{
    use CastsFromMixed;

    public ?bool $scheduled;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->scheduled = self::nullableBool($parameters, 'scheduled');
    }
}
