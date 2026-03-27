<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice;

readonly class IssuedEInvoiceRejectionReason
{
    public ?string $reason;

    public ?string $eiStatus;

    public ?string $solution;

    public ?string $code;

    public ?string $date;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->reason = $parameters['reason'] ?? null;
        $this->eiStatus = $parameters['ei_status'] ?? null;
        $this->solution = $parameters['solution'] ?? null;
        $this->code = $parameters['code'] ?? null;
        $this->date = $parameters['date'] ?? null;
    }
}
