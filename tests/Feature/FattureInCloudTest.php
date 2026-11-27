<?php

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Client;
use OfflineAgency\LaravelFattureInCloudV2\Exceptions\ConfigurationException;
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloud;
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloudManager;

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
            'default' => ['id' => 'default_id', 'bearer' => 'default_bearer'],
            'my-company' => ['id' => 'company_id', 'bearer' => 'company_bearer'],
        ]);

        $fatture = new FattureInCloud(null, null, 'my-company');

        expect($fatture->getCompanyId())->toBe('company_id')
            ->and($fatture->getAccessToken())->toBe('company_bearer');
    });

    it('falls back to first company when no valid default is configured', function () {
        Config::set('fatture-in-cloud-v2.companies', [
            'first-company' => ['id' => 'first_id',  'bearer' => 'first_bearer'],
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
    it('throws when a named company is not configured', function () {
        new FattureInCloud(companyName: 'acme');
    })->throws(ConfigurationException::class, "Company 'acme' is not configured");

    it('throws from forCompany when the company is not configured', function () {
        app(FattureInCloudManager::class)->forCompany('typo');
    })->throws(ConfigurationException::class, "Company 'typo' is not configured");

    it('throws before sending a request when the company id is missing', function () {
        Http::fake();
        Config::set('fatture-in-cloud-v2.companies.default.id', '');

        try {
            (new Client())->list();
        } finally {
            Http::assertNothingSent();
        }
    })->throws(ConfigurationException::class, 'FCV2_DEFAULT_ID');

    it('throws before sending a request when the access token is missing', function () {
        Http::fake();
        Config::set('fatture-in-cloud-v2.companies.default.bearer', '');

        try {
            (new Client())->list();
        } finally {
            Http::assertNothingSent();
        }
    })->throws(ConfigurationException::class, 'FCV2_DEFAULT_BEARER');

    it('names the config key when a named company has no access token', function () {
        Http::fake();
        Config::set('fatture-in-cloud-v2.companies.acme', ['id' => '123', 'bearer' => '']);

        (new Client(new FattureInCloud(companyName: 'acme')))->list();
    })->throws(ConfigurationException::class, "access token (bearer) is missing for company 'acme'. Set companies.acme.bearer");

    it('names the config key when a named company has no id', function () {
        Http::fake();
        Config::set('fatture-in-cloud-v2.companies.acme', ['id' => '', 'bearer' => 'token']);

        (new Client(new FattureInCloud(companyName: 'acme')))->list();
    })->throws(ConfigurationException::class, "company ID is missing for company 'acme'. Set companies.acme.id");

    it('explains how to configure a company when none is configured', function () {
        Http::fake();
        Config::set('fatture-in-cloud-v2.companies', []);

        (new Client())->list();
    })->throws(ConfigurationException::class, 'Configure a company in config/fatture-in-cloud-v2.php or pass it to the FattureInCloud constructor');

    it('does not throw on construction when credentials are empty', function () {
        Config::set('fatture-in-cloud-v2.companies', []);

        expect(new FattureInCloud())->toBeInstanceOf(FattureInCloud::class);
    });
})->covers(
    FattureInCloud::class,
    ConfigurationException::class,
);
