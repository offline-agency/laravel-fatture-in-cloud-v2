<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class ReceivedDocumentTotals
{
    use CastsFromMixed;

    public ?float $amount_due;

    public ?float $payments_sum;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->amount_due = self::nullableFloat($parameters, 'amount_due');
        $this->payments_sum = self::nullableFloat($parameters, 'payments_sum');
    }
}
