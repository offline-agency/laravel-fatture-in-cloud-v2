<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Console\TestConnectionCommand;

describe('fic:test-connection', function () {
    it('shows user info on successful connection', function () {
        Http::fake([
            '*/user/info' => Http::response([
                'data' => [
                    'id' => 1,
                    'name' => 'Test User',
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'email' => 'test@example.com',
                    'hash' => 'abc123',
                    'picture' => null,
                ],
                'info' => [
                    'need_password_change' => false,
                    'need_marketing_consents_confirmation' => false,
                ],
                'email_confirmation_state' => [
                    'need_confirmation' => false,
                ],
            ]),
        ]);

        $this->artisan('fic:test-connection')
            ->expectsOutputToContain('Connection successful')
            ->expectsOutputToContain('Test User')
            ->expectsOutputToContain('test@example.com')
            ->assertSuccessful();
    });

    it('shows error on failed connection', function () {
        Http::fake([
            '*/user/info' => Http::response(['error' => 'Unauthorized'], 401),
        ]);

        $this->artisan('fic:test-connection')
            ->expectsOutputToContain('Connection failed')
            ->assertFailed();
    });
})->covers(TestConnectionCommand::class);
