<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class ReceiptPreCreateInfo
{
    use CastsFromMixed;

    public mixed $numerations;

    public mixed $numerationsList;

    public mixed $rcCentersList;

    public mixed $paymentAccountsList;

    public mixed $categoriesList;

    public mixed $vatTypesList;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->numerations = self::mixedValue($parameters, 'numerations');
        $this->numerationsList = self::mixedValue($parameters, 'numerations_list');
        $this->rcCentersList = self::mixedValue($parameters, 'rc_centers_list');
        $this->paymentAccountsList = self::mixedValue($parameters, 'payment_accounts_list');
        $this->categoriesList = self::mixedValue($parameters, 'categories_list');
        $this->vatTypesList = self::mixedValue($parameters, 'vat_types_list');
    }
}
