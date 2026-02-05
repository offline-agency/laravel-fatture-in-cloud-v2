<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument;

readonly class ReceivedDocumentPreCreateInfo
{
    public mixed $default_values;

    public mixed $items_default_values;

    public ?array $countries_list;

    public ?array $currencies_list;

    public ?array $categories_list;

    public ?array $payment_accounts_list;

    public ?array $vat_types_list;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->default_values = $parameters['default_values'] ?? null;
        $this->items_default_values = $parameters['items_default_values'] ?? null;
        $this->countries_list = $parameters['countries_list'] ?? null;
        $this->currencies_list = $parameters['currencies_list'] ?? null;
        $this->categories_list = $parameters['categories_list'] ?? null;
        $this->payment_accounts_list = $parameters['payment_accounts_list'] ?? null;
        $this->vat_types_list = $parameters['vat_types_list'] ?? null;
    }
}
