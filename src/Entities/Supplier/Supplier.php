<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier;

readonly class Supplier
{
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
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (!is_array($parameters)) {
            $parameters = [];
        }

        $this->id = $parameters['id'] ?? null;
        $this->code = $parameters['code'] ?? null;
        $this->name = $parameters['name'] ?? null;
        $this->type = $parameters['type'] ?? null;
        $this->firstName = $parameters['first_name'] ?? null;
        $this->lastName = $parameters['last_name'] ?? null;
        $this->contactPerson = $parameters['contact_person'] ?? null;
        $this->vatNumber = $parameters['vat_number'] ?? null;
        $this->taxCode = $parameters['tax_code'] ?? null;
        $this->addressStreet = $parameters['address_street'] ?? null;
        $this->addressPostalCode = $parameters['address_postal_code'] ?? null;
        $this->addressCity = $parameters['address_city'] ?? null;
        $this->addressProvince = $parameters['address_province'] ?? null;
        $this->addressExtra = $parameters['address_extra'] ?? null;
        $this->country = $parameters['country'] ?? null;
        $this->email = $parameters['email'] ?? null;
        $this->certifiedEmail = $parameters['certified_email'] ?? null;
        $this->phone = $parameters['phone'] ?? null;
        $this->fax = $parameters['fax'] ?? null;
        $this->notes = $parameters['notes'] ?? null;
        $this->createdAt = $parameters['created_at'] ?? null;
        $this->updatedAt = $parameters['updated_at'] ?? null;
    }
}
