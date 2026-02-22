<?php

use Illuminate\Http\Client\PendingRequest;
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
});
