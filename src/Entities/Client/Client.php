<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Client;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class Client
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

    public mixed $defaultVat;

    public ?int $defaultPaymentTerms;

    public ?string $defaultPaymentTermsType;

    public mixed $defaultPaymentMethod;

    public ?string $bankName;

    public ?string $bankIban;

    public ?string $bankSwiftCode;

    public ?string $shippingAddress;

    public ?bool $eInvoice;

    public ?string $eiCode;

    public ?bool $discountHighlight;

    public ?float $defaultDiscount;

    public ?bool $hasIntentDeclaration;

    public ?string $intentDeclarationProtocolNumber;

    public ?string $intentDeclarationProtocolDate;

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
        $this->defaultVat = self::mixedValue($parameters, 'default_vat');
        $this->defaultPaymentTerms = self::nullableInt($parameters, 'default_payment_terms');
        $this->defaultPaymentTermsType = self::nullableString($parameters, 'default_payment_terms_type');
        $this->defaultPaymentMethod = self::mixedValue($parameters, 'default_payment_method');
        $this->bankName = self::nullableString($parameters, 'bank_name');
        $this->bankIban = self::nullableString($parameters, 'bank_iban');
        $this->bankSwiftCode = self::nullableString($parameters, 'bank_swift_code');
        $this->shippingAddress = self::nullableString($parameters, 'shipping_address');
        $this->eInvoice = self::nullableBool($parameters, 'e_invoice');
        $this->eiCode = self::nullableString($parameters, 'ei_code');
        $this->discountHighlight = self::nullableBool($parameters, 'discount_highlight');
        $this->defaultDiscount = self::nullableFloat($parameters, 'default_discount');
        $this->hasIntentDeclaration = self::nullableBool($parameters, 'has_intent_declaration');
        $this->intentDeclarationProtocolNumber = self::nullableString($parameters, 'intent_declaration_protocol_number');
        $this->intentDeclarationProtocolDate = self::nullableString($parameters, 'intent_declaration_protocol_date');
        $this->createdAt = self::nullableString($parameters, 'created_at');
        $this->updatedAt = self::nullableString($parameters, 'updated_at');
    }
}
