<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class ReceiptMonthlyTotals
{
    use CastsFromMixed;

    public ?float $net;

    public ?float $gross;

    public ?int $count;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->net = self::nullableFloat($parameters, 'net');
        $this->gross = self::nullableFloat($parameters, 'gross');
        $this->count = self::nullableInt($parameters, 'count');
    }
}
