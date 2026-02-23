<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\User;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\User\Company as CompanyEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\User\CompanyList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\User\User as UserEntity;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\UserFakeResponse;

describe('User Entity', function () {
    it('gets user info', function () {
        Http::fake([
            '*/user/info' => Http::response(
                (new UserFakeResponse())->getUserFakeDetail()
            ),
        ]);

        $api = new User();
        $response = $api->userInfo();

        expect($response)->toBeInstanceOf(UserEntity::class);
    });

    it('handles error on user info', function () {
        Http::fake([
            '*/user/info' => Http::response(
                (new UserFakeResponse())->getUserFakeError(),
                401
            ),
        ]);

        $api = new User();
        $response = $api->userInfo();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('lists user companies', function () {
        Http::fake([
            '*/user/companies' => Http::response(
                (new UserFakeResponse())->getCompaniesFakeList()
            ),
        ]);

        $api = new User();
        $response = $api->listCompanies();

        expect($response)->toBeInstanceOf(CompanyList::class)
            ->getItems()->toBeArray()->toHaveCount(2)
            ->getItems()->{0}->toBeInstanceOf(CompanyEntity::class);
    });

    it('checks if companies list has items', function () {
        Http::fake([
            '*/user/companies' => Http::response(
                (new UserFakeResponse())->getCompaniesFakeList()
            ),
        ]);

        $api = new User();
        $response = $api->listCompanies();

        expect($response->hasItems())->toBeTrue();
    });

    it('handles error on companies list', function () {
        Http::fake([
            '*/user/companies' => Http::response(
                (new UserFakeResponse())->getUserFakeError(),
                401
            ),
        ]);

        $api = new User();
        $response = $api->listCompanies();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('checks if companies list is empty', function () {
        Http::fake([
            '*/user/companies' => Http::response(
                (new UserFakeResponse())->getEmptyCompaniesFakeList()
            ),
        ]);

        $api = new User();
        $response = $api->listCompanies();

        expect($response->hasItems())->toBeFalse();
    });

    it('handles null constructor parameter', function () {
        $entity = new CompanyEntity(null);

        expect($entity->id)->toBeNull()
            ->and($entity->name)->toBeNull();
    });
});
