<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Company;

readonly class Company
{
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
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->id = $parameters['id'] ?? null;
        $this->name = $parameters['name'] ?? null;
        $this->alias = $parameters['alias'] ?? null;
        $this->vatNumber = $parameters['vat_number'] ?? null;
        $this->taxCode = $parameters['tax_code'] ?? null;
        $this->email = $parameters['email'] ?? null;
        $this->type = $parameters['type'] ?? null;
        $this->fic = isset($parameters['fic']) ? (bool) $parameters['fic'] : null;
        $this->ficPlanName = $parameters['fic_plan_name'] ?? null;
        $this->ficSignupDate = $parameters['fic_signup_date'] ?? null;
        $this->ficLicenseExpire = $parameters['fic_license_expire'] ?? null;
        $this->useFic = isset($parameters['use_fic']) ? (bool) $parameters['use_fic'] : null;
        $this->ficNeedSetup = isset($parameters['fic_need_setup']) ? (bool) $parameters['fic_need_setup'] : null;
        $this->ficLicenseType = $parameters['fic_license_type'] ?? null;
        $this->dic = isset($parameters['dic']) ? (bool) $parameters['dic'] : null;
        $this->dicPlanName = $parameters['dic_plan_name'] ?? null;
        $this->dicSignupDate = $parameters['dic_signup_date'] ?? null;
        $this->dicLicenseExpire = $parameters['dic_license_expire'] ?? null;
        $this->useDic = isset($parameters['use_dic']) ? (bool) $parameters['use_dic'] : null;
        $this->dicLicenseType = $parameters['dic_license_type'] ?? null;
        $this->registrationService = $parameters['registration_service'] ?? null;
        $this->canUseCoupon = isset($parameters['can_use_coupon']) ? (bool) $parameters['can_use_coupon'] : null;
        $this->accessInfo = $parameters['access_info'] ?? null;
        $this->planInfo = $parameters['plan_info'] ?? null;
        $this->isAccountant = isset($parameters['is_accountant']) ? (bool) $parameters['is_accountant'] : null;
        $this->accountantId = $parameters['accountant_id'] ?? null;
        $this->ficPaymentSubject = $parameters['fic_payment_subject'] ?? null;
        $this->dicPaymentSubject = $parameters['dic_payment_subject'] ?? null;
    }
}
