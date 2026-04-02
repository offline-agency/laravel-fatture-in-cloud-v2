<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Console;

use Illuminate\Console\Command;
use OfflineAgency\LaravelFattureInCloudV2\Api\User;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloud;

class TestConnectionCommand extends Command
{
    protected $signature = 'fic:test-connection {--company= : Named company from config}';

    protected $description = 'Test the connection to Fatture in Cloud API';

    public function handle(): int
    {
        /** @var string|null $companyName */
        $companyName = $this->option('company');

        $connector = new FattureInCloud(companyName: $companyName);
        $userApi = new User($connector);
        $result = $userApi->userInfo();

        if ($result instanceof Error) {
            $this->error('Connection failed!');
            $this->line((string) json_encode($result->error, JSON_PRETTY_PRINT));

            return self::FAILURE;
        }

        $this->info('Connection successful!');
        $this->table(
            ['Field', 'Value'],
            [
                ['ID', (string) ($result->id ?? '-')],
                ['Name', $result->name ?? '-'],
                ['Email', $result->email ?? '-'],
                ['Hash', $result->hash ?? '-'],
                ['Needs Confirmation', $result->needConfirmation ? 'Yes' : 'No'],
            ]
        );

        return self::SUCCESS;
    }
}
