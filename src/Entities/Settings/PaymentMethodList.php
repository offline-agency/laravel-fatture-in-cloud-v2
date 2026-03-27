<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

readonly class PaymentMethodList
{
    /**
     * @var array<PaymentMethod>
     */
    public array $items;

    public function __construct(object $paymentMethodResponse)
    {
        $this->items = array_map(function ($paymentMethod) {
            return new PaymentMethod($paymentMethod);
        }, $paymentMethodResponse->data);
    }

    /**
     * @return array<PaymentMethod>
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
