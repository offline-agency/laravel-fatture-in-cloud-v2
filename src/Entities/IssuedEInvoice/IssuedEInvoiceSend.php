<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice;

readonly class IssuedEInvoiceSend
{
    public ?string $name;

    public ?string $date;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->name = $parameters['name'] ?? null;
        $this->date = $parameters['date'] ?? null;
    }
}
