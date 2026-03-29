<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class IssuedEInvoiceVerifyXML
{
    use CastsFromMixed;

    public ?bool $success;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $success = $parameters['success'] ?? null;
        $this->success = isset($success) ? (bool) $success : null;
    }
}
