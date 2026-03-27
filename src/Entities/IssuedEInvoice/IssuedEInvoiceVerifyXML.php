<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice;

readonly class IssuedEInvoiceVerifyXML
{
    public ?bool $success;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $success = $parameters['success'] ?? null;
        $this->success = isset($success) ? (bool) $success : null;
    }
}
