<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class RevenueCenters extends AbstractEntity
{
    use CastsFromMixed;

    public ?string $data;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->data = self::nullableString($parameters, 'data');
    }
}
