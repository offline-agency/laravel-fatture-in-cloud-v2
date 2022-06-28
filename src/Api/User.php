<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\User\User as UserEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\User\CompanyList;

class User extends Api
{
    public function userInfo()
    {
        $response = $this->get(
            'user/info',
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $user = $response->data;

        $complete_user = (object)array_merge(
            (array)$user->data,
            (array)$user->info,
            (array)$user->email_confirmation_state
        );

        return new UserEntity($complete_user);
    }

    public function listCompanies(
        ?array $additional_data = []
    )
    {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            'user/companies',
            $additional_data
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $user_company_response = $response->data->data;

        return new CompanyList($user_company_response);
    }
}
