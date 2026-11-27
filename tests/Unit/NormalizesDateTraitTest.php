<?php

declare(strict_types=1);

use OfflineAgency\LaravelFattureInCloudV2\Traits\NormalizesDatesTrait;

// Expose protected methods for testing
class NormalizesDateTraitTestHelper
{
    use NormalizesDatesTrait {
        normalizeDateToYmd as public;
        isValidYmd as public;
        normalizeBodyDate as public;
    }
}

covers(NormalizesDatesTrait::class);

describe('NormalizesDatesTrait', function () {
    beforeEach(function () {
        $this->helper = new NormalizesDateTraitTestHelper();
    });

    // --- normalizeDateToYmd ---
    it('normalizeDateToYmd passes through valid Y-m-d string', function () {
        expect($this->helper->normalizeDateToYmd('2024-01-15'))->toBe('2024-01-15');
    });

    it('normalizeDateToYmd formats DateTimeInterface', function () {
        $date = new DateTime('2024-03-20');
        expect($this->helper->normalizeDateToYmd($date))->toBe('2024-03-20');
    });

    it('normalizeDateToYmd normalizes non-padded date', function () {
        expect($this->helper->normalizeDateToYmd('2024-1-5'))->toBe('2024-01-05');
    });

    it('normalizeDateToYmd parses human-readable string', function () {
        expect($this->helper->normalizeDateToYmd('January 15, 2024'))->toBe('2024-01-15');
    });

    it('normalizeDateToYmd returns null for invalid inputs', function (mixed $input) {
        expect($this->helper->normalizeDateToYmd($input))->toBeNull();
    })->with([
        'null' => [null],
        'empty string' => [''],
        'not a date' => ['not-a-date'],
        'integer' => [12345],
        'array' => [['2024-01-01']],
    ]);

    it('normalizeDateToYmd lets an overflowing date roll over, as createFromFormat does', function () {
        // Documents existing behaviour rather than endorsing it: February 30th rolls into March.
        expect($this->helper->normalizeDateToYmd('2026-02-30'))->toBe('2026-03-02');
    });

    it('normalizeDateToYmd falls back to the DateTime constructor for other formats', function (string $input) {
        expect($this->helper->normalizeDateToYmd($input))->toBe('2026-08-24');
    })->with([
        'slashes' => ['2026/08/24'],
        'd-m-Y' => ['24-08-2026'],
        'ISO 8601 with time' => ['2026-08-24T10:00:00+02:00'],
    ]);

    it('normalizeDateToYmd returns null for d/m/Y, which PHP reads as m/d/Y', function () {
        expect($this->helper->normalizeDateToYmd('24/08/2026'))->toBeNull();
    });

    it('normalizeDateToYmd returns null for non-string scalars', function (mixed $input) {
        expect($this->helper->normalizeDateToYmd($input))->toBeNull();
    })->with(['float' => [1.5], 'bool' => [true]]);

    // --- isValidYmd ---
    it('isValidYmd returns true for valid zero-padded date', function () {
        expect($this->helper->isValidYmd('2024-01-15'))->toBeTrue();
    });

    it('isValidYmd returns false for invalid dates', function (string $input) {
        expect($this->helper->isValidYmd($input))->toBeFalse();
    })->with([
        'non-padded' => ['2024-1-5'],
        'invalid month' => ['2024-13-01'],
        'invalid day' => ['2024-01-32'],
        'not a date' => ['abc'],
    ]);

    // --- normalizeBodyDate ---
    it('normalizeBodyDate normalizes date at dot path', function () {
        $body = ['data' => ['date' => '2024-1-5']];
        $result = $this->helper->normalizeBodyDate($body, 'data.date');
        expect($result['data']['date'])->toBe('2024-01-05');
    });

    it('normalizeBodyDate leaves body unchanged when path missing', function () {
        $body = ['data' => ['name' => 'test']];
        $result = $this->helper->normalizeBodyDate($body, 'data.date');
        expect($result)->toBe($body);
    });

    it('normalizeBodyDate leaves body unchanged when value is null', function () {
        $body = ['data' => ['date' => null]];
        $result = $this->helper->normalizeBodyDate($body, 'data.date');
        expect($result['data']['date'])->toBeNull();
    });
});
