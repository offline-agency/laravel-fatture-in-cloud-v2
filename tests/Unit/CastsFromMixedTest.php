<?php

declare(strict_types=1);

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

// Expose protected static methods for testing
class CastsFromMixedTestHelper
{
    use CastsFromMixed {
        nullableString as public;
        nullableInt as public;
        nullableFloat as public;
        nullableBool as public;
        nullableArray as public;
        nullableObject as public;
        mixedValue as public;
        normalizeParameters as public;
    }
}

covers(CastsFromMixed::class);

describe('CastsFromMixed', function () {
    // --- nullableString ---
    it('nullableString returns string as-is', function () {
        expect(CastsFromMixedTestHelper::nullableString(['k' => 'hello'], 'k'))->toBe('hello');
    });

    it('nullableString casts scalar types to string', function (mixed $input, string $expected) {
        expect(CastsFromMixedTestHelper::nullableString(['k' => $input], 'k'))->toBe($expected);
    })->with([
        'int' => [42, '42'],
        'float' => [3.14, '3.14'],
        'bool true' => [true, '1'],
        'bool false' => [false, ''],
    ]);

    it('nullableString returns null for non-scalar or missing', function (array $data) {
        expect(CastsFromMixedTestHelper::nullableString($data, 'k'))->toBeNull();
    })->with([
        'null value' => [['k' => null]],
        'array value' => [['k' => [1, 2]]],
        'object value' => [['k' => new stdClass()]],
        'missing key' => [[]],
    ]);

    // --- nullableInt ---
    it('nullableInt returns int as-is', function () {
        expect(CastsFromMixedTestHelper::nullableInt(['k' => 42], 'k'))->toBe(42);
    });

    it('nullableInt casts scalar types to int', function (mixed $input, int $expected) {
        expect(CastsFromMixedTestHelper::nullableInt(['k' => $input], 'k'))->toBe($expected);
    })->with([
        'float' => [3.9, 3],
        'string' => ['7', 7],
        'bool true' => [true, 1],
        'bool false' => [false, 0],
    ]);

    it('nullableInt returns null for non-scalar or missing', function (array $data) {
        expect(CastsFromMixedTestHelper::nullableInt($data, 'k'))->toBeNull();
    })->with([
        'null' => [['k' => null]],
        'array' => [['k' => [1]]],
        'missing' => [[]],
    ]);

    // --- nullableFloat ---
    it('nullableFloat returns float as-is', function () {
        expect(CastsFromMixedTestHelper::nullableFloat(['k' => 3.14], 'k'))->toBe(3.14);
    });

    it('nullableFloat casts numeric types', function (mixed $input, float $expected) {
        expect(CastsFromMixedTestHelper::nullableFloat(['k' => $input], 'k'))->toBe($expected);
    })->with([
        'int' => [42, 42.0],
        'numeric string' => ['3.14', 3.14],
    ]);

    it('nullableFloat returns null for non-numeric', function (array $data) {
        expect(CastsFromMixedTestHelper::nullableFloat($data, 'k'))->toBeNull();
    })->with([
        'null' => [['k' => null]],
        'non-numeric string' => [['k' => 'abc']],
        'array' => [['k' => []]],
        'missing' => [[]],
    ]);

    // --- nullableBool ---
    it('nullableBool returns bool as-is', function (bool $input) {
        expect(CastsFromMixedTestHelper::nullableBool(['k' => $input], 'k'))->toBe($input);
    })->with([true, false]);

    it('nullableBool casts int and string to bool', function (mixed $input, bool $expected) {
        expect(CastsFromMixedTestHelper::nullableBool(['k' => $input], 'k'))->toBe($expected);
    })->with([
        'int 1' => [1, true],
        'int 0' => [0, false],
        'string "1"' => ['1', true],
        'string ""' => ['', false],
    ]);

    it('nullableBool returns null for non-castable', function (array $data) {
        expect(CastsFromMixedTestHelper::nullableBool($data, 'k'))->toBeNull();
    })->with([
        'null' => [['k' => null]],
        'array' => [['k' => []]],
        'missing' => [[]],
    ]);

    // --- nullableArray ---
    it('nullableArray returns array as-is', function () {
        expect(CastsFromMixedTestHelper::nullableArray(['k' => [1, 2, 3]], 'k'))->toBe([1, 2, 3]);
    });

    it('nullableArray returns null for non-array', function (array $data) {
        expect(CastsFromMixedTestHelper::nullableArray($data, 'k'))->toBeNull();
    })->with([
        'null' => [['k' => null]],
        'string' => [['k' => 'abc']],
        'missing' => [[]],
    ]);

    // --- nullableObject ---
    it('nullableObject returns object as-is', function () {
        $obj = new stdClass();
        expect(CastsFromMixedTestHelper::nullableObject(['k' => $obj], 'k'))->toBe($obj);
    });

    it('nullableObject returns null for non-object', function (array $data) {
        expect(CastsFromMixedTestHelper::nullableObject($data, 'k'))->toBeNull();
    })->with([
        'null' => [['k' => null]],
        'array' => [['k' => []]],
        'missing' => [[]],
    ]);

    // --- mixedValue ---
    it('mixedValue returns the raw value', function () {
        expect(CastsFromMixedTestHelper::mixedValue(['k' => 'anything'], 'k'))->toBe('anything');
    });

    it('mixedValue returns null for missing key', function () {
        expect(CastsFromMixedTestHelper::mixedValue([], 'k'))->toBeNull();
    });

    // --- normalizeParameters ---
    it('normalizeParameters converts stdClass to array', function () {
        $obj = (object) ['name' => 'test', 'id' => 1];
        expect(CastsFromMixedTestHelper::normalizeParameters($obj))->toBe(['name' => 'test', 'id' => 1]);
    });

    it('normalizeParameters passes array through with string keys', function () {
        expect(CastsFromMixedTestHelper::normalizeParameters(['a' => 1, 'b' => 2]))->toBe(['a' => 1, 'b' => 2]);
    });

    it('normalizeParameters returns empty array for null', function () {
        expect(CastsFromMixedTestHelper::normalizeParameters(null))->toBe([]);
    });

    it('normalizeParameters returns empty array for string', function () {
        expect(CastsFromMixedTestHelper::normalizeParameters('invalid'))->toBe([]);
    });
});
