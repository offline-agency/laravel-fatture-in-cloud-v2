<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\User;

readonly class Company
{
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
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->id = $parameters['id'] ?? null;
        $this->name = $parameters['name'] ?? null;
        $this->taxCode = $parameters['tax_code'] ?? null;
        $this->type = $parameters['type'] ?? null;
        $this->accessToken = $parameters['access_token'] ?? null;
        $this->connectionId = isset($parameters['connection_id']) ? (int) $parameters['connection_id'] : null;
        $this->controlledCompanies = $parameters['controlled_companies'] ?? null;
        $this->alias = $parameters['alias'] ?? null;
        $this->vatNumber = $parameters['vat_number'] ?? null;
        $this->fic = $parameters['fic'] ?? null;
        $this->dic = $parameters['dic'] ?? null;
        $this->ficPlan = $parameters['fic_plan'] ?? null;
        $this->ficLicenseExpire = $parameters['fic_license_expire'] ?? null;
        $this->permissions = $parameters['permissions'] ?? null;
    }
}
