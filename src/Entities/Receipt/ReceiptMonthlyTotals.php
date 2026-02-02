<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt;

readonly class ReceiptMonthlyTotals
{
    public ?float $net;
    public ?float $gross;
    public ?int $count;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->net = $parameters['net'] ?? null;
        $this->gross = $parameters['gross'] ?? null;
        $this->count = $parameters['count'] ?? null;
    }
}
