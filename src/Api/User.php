<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelFattureInCloudV2\Entities\User\User as UserEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\User\CompanyList;

class User extends Api
{
    public function userInfo()
    {
        $response = $this->get(
            '/user/info',
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $user = $response->data->data;

        return new UserEntity($user);
    }

    public function listCompanies(
        ?array $additional_data = []
    )
    {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            '/user/companies',
            $additional_data
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $companies = $response->data->data->companies[0];
        return new CompanyList($companies);
    }
}
