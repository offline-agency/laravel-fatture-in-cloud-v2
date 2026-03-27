<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\User\CompanyList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\User\User as UserEntity;

class User extends Api
{
    /**
     * Get current user info.
     */
    public function userInfo(): UserEntity|Error
    {
        /** @var object $response */
        $response = $this->get(
            'user/info',
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $user = $response->data;

        $completeUser = (object) array_merge(
            (array) $user->data,
            (array) $user->info,
            (array) $user->email_confirmation_state
        );

        return new UserEntity($completeUser);
    }

    /**
     * List user companies. OPTIONAL query: fields, fieldset.
     *
     * @param  array{fields?: string, fieldset?: string}  $additionalData
     */
    public function listCompanies(array $additionalData = []): CompanyList|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
        ]);

        /** @var object $response */
        $response = $this->get(
            'user/companies',
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $userCompanyResponse = $response->data->data;

        return new CompanyList($userCompanyResponse);
    }
}
