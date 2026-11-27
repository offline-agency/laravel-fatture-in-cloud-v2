<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\PriceList;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class PriceList
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $name;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->name = self::nullableString($parameters, 'name');
    }
}
