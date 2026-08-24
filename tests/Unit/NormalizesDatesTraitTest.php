<?php

use OfflineAgency\LaravelFattureInCloudV2\Traits\NormalizesDatesTrait;

describe('NormalizesDatesTrait', function () {
    beforeEach(function () {
        // The trait's methods are protected. Driving them through an Api class
        // would not reach every branch: Cashbook::list() validates
        // date_format:Y-m-d before normalizing, so a malformed date is rejected
        // upstream. This exposes them directly instead.
        $this->dates = new class()
        {
            use NormalizesDatesTrait;

            public function ymd(mixed $value): ?string
            {
                return $this->normalizeDateToYmd($value);
            }

            public function validYmd(string $date): bool
            {
                return $this->isValidYmd($date);
            }

            /**
             * @param  array<string, mixed>  $body
             * @return array<string, mixed>
             */
            public function bodyDate(array $body, string $dotPath): array
            {
                return $this->normalizeBodyDate($body, $dotPath);
            }
        };
    });

    it('returns null for null and empty string', function () {
        expect($this->dates->ymd(null))->toBeNull()
            ->and($this->dates->ymd(''))->toBeNull();
    });

    it('formats a DateTimeInterface', function () {
        expect($this->dates->ymd(new DateTimeImmutable('2026-08-24 15:30:00')))
            ->toBe('2026-08-24')
            ->and($this->dates->ymd(new DateTime('2026-01-02 00:00:00')))
            ->toBe('2026-01-02');
    });

    it('returns null for values that are neither string nor DateTimeInterface', function () {
        expect($this->dates->ymd(123))->toBeNull()
            ->and($this->dates->ymd(1.5))->toBeNull()
            ->and($this->dates->ymd(true))->toBeNull()
            ->and($this->dates->ymd(['2026-08-24']))->toBeNull();
    });

    it('passes an already valid Y-m-d string through untouched', function () {
        expect($this->dates->ymd('2026-08-24'))->toBe('2026-08-24');
    });

    it('zero-pads a Y-m-d string that is not zero-padded', function () {
        // isValidYmd() fails (the round-trip does not match the input) but
        // createFromFormat('Y-m-d') still parses it, because PHP's `m` and `d`
        // accept one or two digits.
        expect($this->dates->ymd('2026-8-24'))->toBe('2026-08-24')
            ->and($this->dates->ymd('2026-8-4'))->toBe('2026-08-04');
    });

    it('lets an overflowing date roll over, as createFromFormat does', function () {
        // Documents existing behaviour rather than endorsing it: February 30th
        // is accepted and rolls into March.
        expect($this->dates->ymd('2026-02-30'))->toBe('2026-03-02');
    });

    it('falls back to the DateTime constructor for other parseable formats', function () {
        // createFromFormat('Y-m-d') returns false for these, so the last
        // resort — new DateTime($value) — is what resolves them.
        expect($this->dates->ymd('24 August 2026'))->toBe('2026-08-24')
            ->and($this->dates->ymd('2026/08/24'))->toBe('2026-08-24')
            ->and($this->dates->ymd('24-08-2026'))->toBe('2026-08-24')
            ->and($this->dates->ymd('2026-08-24T10:00:00+02:00'))->toBe('2026-08-24');
    });

    it('returns null when the value cannot be parsed at all', function () {
        // new DateTime() throws and the catch swallows it.
        expect($this->dates->ymd('garbage'))->toBeNull()
            ->and($this->dates->ymd('24/08/2026'))->toBeNull()
            ->and($this->dates->ymd('not a date'))->toBeNull();
    });

    it('validates zero-padded Y-m-d strictly', function () {
        expect($this->dates->validYmd('2026-08-24'))->toBeTrue()
            ->and($this->dates->validYmd('2026-8-24'))->toBeFalse()
            ->and($this->dates->validYmd('2026-02-30'))->toBeFalse()
            ->and($this->dates->validYmd('garbage'))->toBeFalse();
    });

    it('normalizes a nested date inside a body', function () {
        $body = $this->dates->bodyDate([
            'data' => ['due_date' => '2026-8-24', 'entity' => ['name' => 'ACME']],
        ], 'data.due_date');

        expect($body['data']['due_date'])->toBe('2026-08-24')
            ->and($body['data']['entity']['name'])->toBe('ACME');
    });

    it('leaves the body untouched when the nested date cannot be normalized', function () {
        $original = ['data' => ['due_date' => 'garbage']];

        expect($this->dates->bodyDate($original, 'data.due_date'))->toBe($original);
    });

    it('leaves the body untouched when the dot path is absent', function () {
        $original = ['data' => ['entity' => ['name' => 'ACME']]];

        expect($this->dates->bodyDate($original, 'data.due_date'))->toBe($original);
    });
});
