<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class Supplier
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $code;

    public ?string $name;

    public ?string $type;

    public ?string $firstName;

    public ?string $lastName;

    public ?string $contactPerson;

    public ?string $vatNumber;

    public ?string $taxCode;

    public ?string $addressStreet;

    public ?string $addressPostalCode;

    public ?string $addressCity;

    public ?string $addressProvince;

    public ?string $addressExtra;

    public ?string $country;

    public ?string $email;

    public ?string $certifiedEmail;

    public ?string $phone;

    public ?string $fax;

    public ?string $notes;

    public ?string $createdAt;

    public ?string $updatedAt;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->code = self::nullableString($parameters, 'code');
        $this->name = self::nullableString($parameters, 'name');
        $this->type = self::nullableString($parameters, 'type');
        $this->firstName = self::nullableString($parameters, 'first_name');
        $this->lastName = self::nullableString($parameters, 'last_name');
        $this->contactPerson = self::nullableString($parameters, 'contact_person');
        $this->vatNumber = self::nullableString($parameters, 'vat_number');
        $this->taxCode = self::nullableString($parameters, 'tax_code');
        $this->addressStreet = self::nullableString($parameters, 'address_street');
        $this->addressPostalCode = self::nullableString($parameters, 'address_postal_code');
        $this->addressCity = self::nullableString($parameters, 'address_city');
        $this->addressProvince = self::nullableString($parameters, 'address_province');
        $this->addressExtra = self::nullableString($parameters, 'address_extra');
        $this->country = self::nullableString($parameters, 'country');
        $this->email = self::nullableString($parameters, 'email');
        $this->certifiedEmail = self::nullableString($parameters, 'certified_email');
        $this->phone = self::nullableString($parameters, 'phone');
        $this->fax = self::nullableString($parameters, 'fax');
        $this->notes = self::nullableString($parameters, 'notes');
        $this->createdAt = self::nullableString($parameters, 'created_at');
        $this->updatedAt = self::nullableString($parameters, 'updated_at');
    }
}
