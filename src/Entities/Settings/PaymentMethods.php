<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class PaymentMethods extends AbstractEntity
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $name;

    public ?string $type;

    public ?bool $isDefault;

    public mixed $defaultPaymentAccount;

    public mixed $details;

    public ?string $bankIban;

    public ?string $bankName;

    public ?string $bankBeneficiary;

    public ?string $eiPaymentMethod;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->name = self::nullableString($parameters, 'name');
        $this->type = self::nullableString($parameters, 'type');
        $this->isDefault = self::nullableBool($parameters, 'is_default');
        $this->defaultPaymentAccount = self::mixedValue($parameters, 'default_payment_account');
        $this->details = self::mixedValue($parameters, 'details');
        $this->bankIban = self::nullableString($parameters, 'bank_iban');
        $this->bankName = self::nullableString($parameters, 'bank_name');
        $this->bankBeneficiary = self::nullableString($parameters, 'bank_beneficiary');
        $this->eiPaymentMethod = self::nullableString($parameters, 'ei_payment_method');
    }
}
