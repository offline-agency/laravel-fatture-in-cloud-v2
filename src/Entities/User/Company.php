<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\User;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class Company
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $name;

    public ?string $taxCode;

    public ?string $type;

    public ?string $accessToken;

    public ?int $connectionId;

    public mixed $controlledCompanies;

    public ?string $alias;

    public ?string $vatNumber;

    public ?bool $fic;

    public ?bool $dic;

    public ?string $ficPlan;

    public ?string $ficLicenseExpire;

    public mixed $permissions;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->name = self::nullableString($parameters, 'name');
        $this->taxCode = self::nullableString($parameters, 'tax_code');
        $this->type = self::nullableString($parameters, 'type');
        $this->accessToken = self::nullableString($parameters, 'access_token');
        $this->connectionId = self::nullableInt($parameters, 'connection_id');
        $this->controlledCompanies = self::mixedValue($parameters, 'controlled_companies');
        $this->alias = self::nullableString($parameters, 'alias');
        $this->vatNumber = self::nullableString($parameters, 'vat_number');
        $this->fic = self::nullableBool($parameters, 'fic');
        $this->dic = self::nullableBool($parameters, 'dic');
        $this->ficPlan = self::nullableString($parameters, 'fic_plan');
        $this->ficLicenseExpire = self::nullableString($parameters, 'fic_license_expire');
        $this->permissions = self::mixedValue($parameters, 'permissions');
    }
}
