<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\User;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class User
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $name;

    public ?string $firstName;

    public ?string $lastName;

    public ?string $email;

    public ?string $hash;

    public ?string $picture;

    public ?bool $needPasswordChange;

    public ?bool $needMarketingConsentsConfirmation;

    public ?bool $needConfirmation;

    public mixed $details;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->name = self::nullableString($parameters, 'name');
        $this->firstName = self::nullableString($parameters, 'first_name');
        $this->lastName = self::nullableString($parameters, 'last_name');
        $this->email = self::nullableString($parameters, 'email');
        $this->hash = self::nullableString($parameters, 'hash');
        $this->picture = self::nullableString($parameters, 'picture');
        $this->needPasswordChange = self::nullableBool($parameters, 'need_password_change');
        $this->needMarketingConsentsConfirmation = self::nullableBool($parameters, 'need_marketing_consents_confirmation');
        $this->needConfirmation = self::nullableBool($parameters, 'need_confirmation');
        $this->details = self::mixedValue($parameters, 'details');
    }
}
