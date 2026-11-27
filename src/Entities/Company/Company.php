<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Company;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class Company
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $name;

    public ?string $alias;

    public ?string $vatNumber;

    public ?string $taxCode;

    public ?string $email;

    public ?string $type;

    public ?bool $fic;

    public ?string $ficPlanName;

    public ?string $ficSignupDate;

    public ?string $ficLicenseExpire;

    public ?bool $useFic;

    public ?bool $ficNeedSetup;

    public ?string $ficLicenseType;

    public ?bool $dic;

    public ?string $dicPlanName;

    public ?string $dicSignupDate;

    public ?string $dicLicenseExpire;

    public ?bool $useDic;

    public ?string $dicLicenseType;

    public ?string $registrationService;

    public ?bool $canUseCoupon;

    public mixed $accessInfo;

    public mixed $planInfo;

    public ?bool $isAccountant;

    public ?int $accountantId;

    public ?string $ficPaymentSubject;

    public ?string $dicPaymentSubject;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->name = self::nullableString($parameters, 'name');
        $this->alias = self::nullableString($parameters, 'alias');
        $this->vatNumber = self::nullableString($parameters, 'vat_number');
        $this->taxCode = self::nullableString($parameters, 'tax_code');
        $this->email = self::nullableString($parameters, 'email');
        $this->type = self::nullableString($parameters, 'type');
        $this->fic = self::nullableBool($parameters, 'fic');
        $this->ficPlanName = self::nullableString($parameters, 'fic_plan_name');
        $this->ficSignupDate = self::nullableString($parameters, 'fic_signup_date');
        $this->ficLicenseExpire = self::nullableString($parameters, 'fic_license_expire');
        $this->useFic = self::nullableBool($parameters, 'use_fic');
        $this->ficNeedSetup = self::nullableBool($parameters, 'fic_need_setup');
        $this->ficLicenseType = self::nullableString($parameters, 'fic_license_type');
        $this->dic = self::nullableBool($parameters, 'dic');
        $this->dicPlanName = self::nullableString($parameters, 'dic_plan_name');
        $this->dicSignupDate = self::nullableString($parameters, 'dic_signup_date');
        $this->dicLicenseExpire = self::nullableString($parameters, 'dic_license_expire');
        $this->useDic = self::nullableBool($parameters, 'use_dic');
        $this->dicLicenseType = self::nullableString($parameters, 'dic_license_type');
        $this->registrationService = self::nullableString($parameters, 'registration_service');
        $this->canUseCoupon = self::nullableBool($parameters, 'can_use_coupon');
        $this->accessInfo = self::mixedValue($parameters, 'access_info');
        $this->planInfo = self::mixedValue($parameters, 'plan_info');
        $this->isAccountant = self::nullableBool($parameters, 'is_accountant');
        $this->accountantId = self::nullableInt($parameters, 'accountant_id');
        $this->ficPaymentSubject = self::nullableString($parameters, 'fic_payment_subject');
        $this->dicPaymentSubject = self::nullableString($parameters, 'dic_payment_subject');
    }
}
