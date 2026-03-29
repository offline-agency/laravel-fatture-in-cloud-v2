<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

readonly class PaymentAccountList
{
    /**
     * @var array<PaymentAccount>
     */
    public array $items;

    public function __construct(\stdClass $paymentAccountResponse)
    {
        $this->items = array_map(function ($paymentAccount) {
            return new PaymentAccount($paymentAccount);
        }, $paymentAccountResponse->data);
    }

    /**
     * @return array<PaymentAccount>
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
