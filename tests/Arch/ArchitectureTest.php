<?php

declare(strict_types=1);

arch('all source files use strict types')
    ->expect('OfflineAgency\LaravelFattureInCloudV2')
    ->toUseStrictTypes();

arch('entity classes are readonly')
    ->expect('OfflineAgency\LaravelFattureInCloudV2\Entities')
    ->classes()
    ->toBeReadonly()
    ->ignoring([
        'OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity',
    ]);

arch('API classes extend base Api')
    ->expect('OfflineAgency\LaravelFattureInCloudV2\Api')
    ->classes()
    ->toExtend('OfflineAgency\LaravelFattureInCloudV2\Api\Api')
    ->ignoring([
        'OfflineAgency\LaravelFattureInCloudV2\Api\Api',
    ]);

arch('no debug functions')
    ->expect(['dd', 'dump', 'ray', 'var_dump', 'print_r'])
    ->not->toBeUsed();

arch('enums are string-backed')
    ->expect('OfflineAgency\LaravelFattureInCloudV2\Enums')
    ->toBeStringBackedEnums();

arch('entities do not depend on Api namespace')
    ->expect('OfflineAgency\LaravelFattureInCloudV2\Entities')
    ->not->toUse('OfflineAgency\LaravelFattureInCloudV2\Api')
    ->ignoring([
        'OfflineAgency\LaravelFattureInCloudV2\Entities\Archive\ArchivePagination',
        'OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook\CashbookPagination',
        'OfflineAgency\LaravelFattureInCloudV2\Entities\Client\ClientPagination',
        'OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument\IssuedDocumentPagination',
        'OfflineAgency\LaravelFattureInCloudV2\Entities\Product\ProductPagination',
        'OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptPagination',
        'OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument\ReceivedDocumentPagination',
        'OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier\SupplierPagination',
        'OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\TaxesPagination',
    ]);
