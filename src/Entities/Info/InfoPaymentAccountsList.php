<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as PaymentAccountsEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class InfoPaymentAccountsList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($payment_accounts_response)
    {
        $this->setItems($payment_accounts_response);
    }

    /**
     * @return array<PaymentAccountsEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    private function setItems(
        $payment_accounts_response
    ): void
    {
        $this->items = array_map(function ($client) {
            return new PaymentAccountsEntity($client);
        }, $payment_accounts_response->data);
    }
}
