<?php

declare(strict_types=1);

use OfflineAgency\LaravelFattureInCloudV2\Api\ApiResponse;

covers(ApiResponse::class);

describe('ApiResponse', function () {
    it('constructs with success true', function () {
        $data = new stdClass();
        $data->id = 1;

        $response = new ApiResponse(success: true, data: $data);

        expect($response->success)->toBeTrue()
            ->and($response->data->id)->toBe(1);
    });

    it('constructs with success false', function () {
        $data = new stdClass();
        $data->error = 'Unauthorized';

        $response = new ApiResponse(success: false, data: $data);

        expect($response->success)->toBeFalse()
            ->and($response->data->error)->toBe('Unauthorized');
    });

    it('is readonly', function () {
        $reflection = new ReflectionClass(ApiResponse::class);

        expect($reflection->isReadOnly())->toBeTrue();
    });
});
