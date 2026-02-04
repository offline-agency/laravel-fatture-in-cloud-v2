<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt;

readonly class ReceiptPreCreateInfo
{
    public mixed $numerations;

    public mixed $numerationsList;

    public mixed $rcCentersList;

    public mixed $paymentAccountsList;

    public mixed $categoriesList;

    public mixed $vatTypesList;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->numerations = $parameters['numerations'] ?? null;
        $this->numerationsList = $parameters['numerations_list'] ?? null;
        $this->rcCentersList = $parameters['rc_centers_list'] ?? null;
        $this->paymentAccountsList = $parameters['payment_accounts_list'] ?? null;
        $this->categoriesList = $parameters['categories_list'] ?? null;
        $this->vatTypesList = $parameters['vat_types_list'] ?? null;
    }
}
