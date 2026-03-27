<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument;

readonly class ReceivedDocumentTotals
{
    public ?float $amount_due;

    public ?float $payments_sum;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->amount_due = isset($parameters['amount_due']) ? (float) $parameters['amount_due'] : null;
        $this->payments_sum = isset($parameters['payments_sum']) ? (float) $parameters['payments_sum'] : null;
    }
}
