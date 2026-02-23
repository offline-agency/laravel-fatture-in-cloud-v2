<?php

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloud;

describe('FattureInCloud', function () {
    it('constructs with config defaults', function () {
        $fatture = new FattureInCloud();

        expect($fatture->getCompanyId())->toBe('fake_id')
            ->and($fatture->getAccessToken())->toBe('fake_bearer');
    });

    it('accepts custom company id and access token', function () {
        $fatture = new FattureInCloud('custom_id', 'custom_token');

        expect($fatture->getCompanyId())->toBe('custom_id')
            ->and($fatture->getAccessToken())->toBe('custom_token');
    });

    it('returns the base url', function () {
        $fatture = new FattureInCloud();

        expect($fatture->getBaseUrl())->toBeString()->not->toBeEmpty();
    });

    it('returns a pending request', function () {
        $fatture = new FattureInCloud();

        expect($fatture->getRequest())->toBeInstanceOf(PendingRequest::class);
    });

    it('custom company id overrides config', function () {
        $fatture = new FattureInCloud('override_id');

        expect($fatture->getCompanyId())->toBe('override_id')
            ->and($fatture->getAccessToken())->toBe('fake_bearer');
    });

    it('custom access token overrides config', function () {
        $fatture = new FattureInCloud(null, 'override_token');

        expect($fatture->getCompanyId())->toBe('fake_id')
            ->and($fatture->getAccessToken())->toBe('override_token');
    });

    it('resolves explicit company name from config', function () {
        Config::set('fatture-in-cloud-v2.companies', [
            'default'    => ['id' => 'default_id', 'bearer' => 'default_bearer'],
            'my-company' => ['id' => 'company_id', 'bearer' => 'company_bearer'],
        ]);

        $fatture = new FattureInCloud(null, null, 'my-company');

        expect($fatture->getCompanyId())->toBe('company_id')
            ->and($fatture->getAccessToken())->toBe('company_bearer');
    });

    it('falls back to first company when no valid default is configured', function () {
        Config::set('fatture-in-cloud-v2.companies', [
            'first-company'  => ['id' => 'first_id',  'bearer' => 'first_bearer'],
            'second-company' => ['id' => 'second_id', 'bearer' => 'second_bearer'],
        ]);

        $fatture = new FattureInCloud();

        expect($fatture->getCompanyId())->toBe('first_id')
            ->and($fatture->getAccessToken())->toBe('first_bearer');
    });

    it('handles empty companies array gracefully', function () {
        Config::set('fatture-in-cloud-v2.companies', []);

        $fatture = new FattureInCloud();

        expect($fatture->getCompanyId())->toBe('')
            ->and($fatture->getAccessToken())->toBe('');
    });
});
