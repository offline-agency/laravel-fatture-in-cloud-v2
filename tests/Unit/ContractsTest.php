<?php

declare(strict_types=1);

use OfflineAgency\LaravelFattureInCloudV2\Contracts\ConnectorInterface;
use OfflineAgency\LaravelFattureInCloudV2\Contracts\FattureInCloudManagerInterface;
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloud;
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloudManager;

covers(
    ConnectorInterface::class,
    FattureInCloudManagerInterface::class,
);

describe('Contracts', function () {
    it('FattureInCloud implements ConnectorInterface', function () {
        expect(new FattureInCloud())->toBeInstanceOf(ConnectorInterface::class);
    });

    it('FattureInCloudManager implements FattureInCloudManagerInterface', function () {
        expect(new FattureInCloudManager())->toBeInstanceOf(FattureInCloudManagerInterface::class);
    });
});
