<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class ReceivedDocumentPreCreateInfo
{
    use CastsFromMixed;

    public mixed $default_values;

    public mixed $items_default_values;

    /** @var array<mixed>|null */
    public ?array $countries_list;

    /** @var array<mixed>|null */
    public ?array $currencies_list;

    /** @var array<mixed>|null */
    public ?array $categories_list;

    /** @var array<mixed>|null */
    public ?array $payment_accounts_list;

    /** @var array<mixed>|null */
    public ?array $vat_types_list;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->default_values = self::mixedValue($parameters, 'default_values');
        $this->items_default_values = self::mixedValue($parameters, 'items_default_values');
        $this->countries_list = self::nullableArray($parameters, 'countries_list');
        $this->currencies_list = self::nullableArray($parameters, 'currencies_list');
        $this->categories_list = self::nullableArray($parameters, 'categories_list');
        $this->payment_accounts_list = self::nullableArray($parameters, 'payment_accounts_list');
        $this->vat_types_list = self::nullableArray($parameters, 'vat_types_list');
    }
}
