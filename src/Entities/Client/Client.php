<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Client;

readonly class Client
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
        $this->defaultVat = $parameters['default_vat'] ?? null;
        $this->defaultPaymentTerms = $parameters['default_payment_terms'] ?? null;
        $this->defaultPaymentTermsType = $parameters['default_payment_terms_type'] ?? null;
        $this->defaultPaymentMethod = $parameters['default_payment_method'] ?? null;
        $this->bankName = $parameters['bank_name'] ?? null;
        $this->bankIban = $parameters['bank_iban'] ?? null;
        $this->bankSwiftCode = $parameters['bank_swift_code'] ?? null;
        $this->shippingAddress = $parameters['shipping_address'] ?? null;
        $this->eInvoice = $parameters['e_invoice'] ?? null;
        $this->eiCode = $parameters['ei_code'] ?? null;
        $this->discountHighlight = $parameters['discount_highlight'] ?? null;
        $this->defaultDiscount = $parameters['default_discount'] ?? null;
        $this->hasIntentDeclaration = $parameters['has_intent_declaration'] ?? null;
        $this->intentDeclarationProtocolNumber = $parameters['intent_declaration_protocol_number'] ?? null;
        $this->intentDeclarationProtocolDate = $parameters['intent_declaration_protocol_date'] ?? null;
        $this->createdAt = $parameters['created_at'] ?? null;
        $this->updatedAt = $parameters['updated_at'] ?? null;
    }
}
