<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\User;

readonly class User
{
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
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->id = $parameters['id'] ?? null;
        $this->name = $parameters['name'] ?? null;
        $this->firstName = $parameters['first_name'] ?? null;
        $this->lastName = $parameters['last_name'] ?? null;
        $this->email = $parameters['email'] ?? null;
        $this->hash = $parameters['hash'] ?? null;
        $this->picture = $parameters['picture'] ?? null;
        $this->needPasswordChange = $parameters['need_password_change'] ?? null;
        $this->needMarketingConsentsConfirmation = $parameters['need_marketing_consents_confirmation'] ?? null;
        $this->needConfirmation = $parameters['need_confirmation'] ?? null;
        $this->details = $parameters['details'] ?? null;
    }
}
