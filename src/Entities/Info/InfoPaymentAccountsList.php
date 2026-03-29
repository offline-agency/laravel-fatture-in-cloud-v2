<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as PaymentAccountsEntity;

readonly class InfoPaymentAccountsList
{
    /**
     * @var array<PaymentAccountsEntity>
     */
    private array $items;

    public function __construct(object $paymentAccountsResponse)
    {
        $this->items = array_map(function ($client) {
            return new PaymentAccountsEntity($client);
        }, $paymentAccountsResponse->data);
    }

    /**
     * @return array<PaymentAccountsEntity>
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
