<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class IssuedEInvoiceRejectionReason
{
    use CastsFromMixed;

    public ?string $reason;

    public ?string $eiStatus;

    public ?string $solution;

    public ?string $code;

    public ?string $date;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->reason = self::nullableString($parameters, 'reason');
        $this->eiStatus = self::nullableString($parameters, 'ei_status');
        $this->solution = self::nullableString($parameters, 'solution');
        $this->code = self::nullableString($parameters, 'code');
        $this->date = self::nullableString($parameters, 'date');
    }
}
