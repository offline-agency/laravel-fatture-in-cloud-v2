<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class IssuedEInvoiceSend
{
    use CastsFromMixed;

    public ?string $name;

    public ?string $date;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->name = self::nullableString($parameters, 'name');
        $this->date = self::nullableString($parameters, 'date');
    }
}
