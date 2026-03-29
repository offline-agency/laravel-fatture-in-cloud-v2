<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Console;

use Illuminate\Console\Command;
use OfflineAgency\LaravelFattureInCloudV2\Api\Archive;
use OfflineAgency\LaravelFattureInCloudV2\Api\Cashbook;
use OfflineAgency\LaravelFattureInCloudV2\Api\Client;
use OfflineAgency\LaravelFattureInCloudV2\Api\Company;
use OfflineAgency\LaravelFattureInCloudV2\Api\Email;
use OfflineAgency\LaravelFattureInCloudV2\Api\Info;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedEInvoice;
use OfflineAgency\LaravelFattureInCloudV2\Api\PaymentAccount;
use OfflineAgency\LaravelFattureInCloudV2\Api\PaymentMethod;
use OfflineAgency\LaravelFattureInCloudV2\Api\PriceList;
use OfflineAgency\LaravelFattureInCloudV2\Api\Product;
use OfflineAgency\LaravelFattureInCloudV2\Api\Receipt;
use OfflineAgency\LaravelFattureInCloudV2\Api\ReceivedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Api\Situation;
use OfflineAgency\LaravelFattureInCloudV2\Api\Supplier;
use OfflineAgency\LaravelFattureInCloudV2\Api\Taxes;
use OfflineAgency\LaravelFattureInCloudV2\Api\User;
use OfflineAgency\LaravelFattureInCloudV2\Api\VatType;
use OfflineAgency\LaravelFattureInCloudV2\Api\Webhook;
use ReflectionClass;
use ReflectionMethod;

class ApiStatusCommand extends Command
{
    protected $signature = 'fic:api-status';

    protected $description = 'List all available Fatture in Cloud API resources and their methods';

    /** @var array<class-string> */
    private const API_CLASSES = [
        Archive::class,
        Cashbook::class,
        Client::class,
        Company::class,
        Email::class,
        Info::class,
        IssuedDocument::class,
        IssuedEInvoice::class,
        PaymentAccount::class,
        PaymentMethod::class,
        PriceList::class,
        Product::class,
        Receipt::class,
        ReceivedDocument::class,
        Situation::class,
        Supplier::class,
        Taxes::class,
        User::class,
        VatType::class,
        Webhook::class,
    ];

    public function handle(): int
    {
        $rows = [];
        $totalMethods = 0;

        foreach (self::API_CLASSES as $class) {
            $reflection = new ReflectionClass($class);
            $methods = array_filter(
                $reflection->getMethods(ReflectionMethod::IS_PUBLIC),
                fn (ReflectionMethod $m) => $m->getDeclaringClass()->getName() === $class
                    && $m->getName() !== '__construct'
            );

            $methodNames = array_map(fn (ReflectionMethod $m) => $m->getName(), $methods);
            sort($methodNames);

            $count = count($methodNames);
            $totalMethods += $count;

            $rows[] = [
                $reflection->getShortName(),
                implode(', ', $methodNames),
                (string) $count,
            ];
        }

        $this->table(['Resource', 'Methods', 'Count'], $rows);
        $this->info("Total: {$totalMethods} endpoints across ".count(self::API_CLASSES).' resources');

        return self::SUCCESS;
    }
}
