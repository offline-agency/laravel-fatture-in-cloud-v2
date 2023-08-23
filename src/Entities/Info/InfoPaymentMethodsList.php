<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as PaymentMethodEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class InfoPaymentMethodsList
{
    use ListTrait;

    private $items;
    private $pagination;

    public function __construct($payment_methods_response)
    {
        $this->setItems($payment_methods_response);
    }

    /**
     * @return array<PaymentMethodEntity>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    private function setItems(
        $payment_methods_response
    ): void
    {
        $this->items = array_map(function ($client) {
            return new PaymentMethodEntity($client);
        }, $payment_methods_response->data);
    }
}
