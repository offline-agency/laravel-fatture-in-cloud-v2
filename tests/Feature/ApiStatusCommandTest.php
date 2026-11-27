<?php

declare(strict_types=1);

use OfflineAgency\LaravelFattureInCloudV2\Console\ApiStatusCommand;

describe('fic:api-status', function () {
    it('lists all API resources and methods', function () {
        $this->artisan('fic:api-status')
            ->expectsOutputToContain('Client')
            ->expectsOutputToContain('IssuedDocument')
            ->expectsOutputToContain('Total:')
            ->assertSuccessful();
    });
})->covers(ApiStatusCommand::class);
