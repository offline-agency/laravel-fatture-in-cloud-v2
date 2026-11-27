<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class PaymentMethod
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $name;

    public ?string $type;

    public ?bool $isDefault;

    public ?object $defaultPaymentAccount;

    /** @var array<mixed>|null */
    public ?array $details;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->name = self::nullableString($parameters, 'name');
        $this->type = self::nullableString($parameters, 'type');
        $this->isDefault = self::nullableBool($parameters, 'is_default');
        $this->defaultPaymentAccount = self::nullableObject($parameters, 'default_payment_account');
        $this->details = self::nullableArray($parameters, 'details');
    }
}
