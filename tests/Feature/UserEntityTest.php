<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\User;
use OfflineAgency\LaravelFattureInCloudV2\Entities\User\User as UserEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\User\CompanyList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\UserFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class UserEntityTest extends TestCase
{
    public function test_user_info()
    {
        Http::fake([
            '/user/info' => Http::response(
                (new UserFakeResponse())->getUserFakeDetail()
            ),
        ]);

        $user = new User();
        $response = $user->userInfo();

        $this->assertNotNull($response);
        $this->assertInstanceOf(UserEntity::class, $response);
    }

    public function test_list_companies()
    {
        Http::fake([
            '/user/companies' => Http::response(
                (new UserFakeResponse())->getCompaniesFakeList()
            ),
        ]);

        $company = new User();
        $response = $company->listCompanies();

        $this->assertNotNull($response);
        $this->assertInstanceOf(CompanyList::class, $response);
    }

    public function test_error_on_list_users()
    {
        Http::fake([
            '/user/companies' => Http::response(
                (new UserFakeResponse())->getUserFakeError(),
                401
            ),
        ]);

        $users = new User();
        $response = $users->listCompanies();

        $this->assertInstanceOf(Error::class, $response);
    }

    public function test_error_on_user_info()
    {
        Http::fake([
            '/user/info' => Http::response(
                (new UserFakeResponse())->getUserFakeError(),
                401
            ),
        ]);

        $users = new User();
        $response = $users->userInfo();

        $this->assertInstanceOf(Error::class, $response);
    }
}
