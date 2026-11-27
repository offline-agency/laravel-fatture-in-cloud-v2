<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as PaymentMethodEntity;

readonly class InfoPaymentMethodsList
{
    /**
     * @var array<PaymentMethodEntity>
     */
    private array $items;

    public function __construct(\stdClass $paymentMethodsResponse)
    {
        $this->items = array_map(function ($client) {
            return new PaymentMethodEntity($client);
        }, $paymentMethodsResponse->data);
    }

    /**
     * @return array<PaymentMethodEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
