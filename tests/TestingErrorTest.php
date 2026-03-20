<?php

declare(strict_types=1);

use Touta\TestingKit\TestingError;

// Scenario: TestingError stores code, message, and context from constructor
it('can be constructed with code, message, and context', function (): void {
    $error = new TestingError('TESTING.STUB_FAILED', 'stub failed', ['key' => 'val']);

    expect($error->code)->toBe('TESTING.STUB_FAILED')
        ->and($error->message)->toBe('stub failed')
        ->and($error->context)->toBe(['key' => 'val']);
});

// Scenario: TestingError defaults context to empty array when omitted
it('defaults context to an empty array', function (): void {
    $error = new TestingError('TESTING.STUB_FAILED', 'stub failed');

    expect($error->context)->toBe([]);
});

// Scenario: STUB_FAILED constant matches domain code convention
it('exposes STUB_FAILED constant', function (): void {
    expect(TestingError::STUB_FAILED)->toBe('TESTING.STUB_FAILED');
});

// Scenario: ASSERTION_FAILED constant matches domain code convention
it('exposes ASSERTION_FAILED constant', function (): void {
    expect(TestingError::ASSERTION_FAILED)->toBe('TESTING.ASSERTION_FAILED');
});

// Scenario: DOUBLE_MISCONFIGURED constant matches domain code convention
it('exposes DOUBLE_MISCONFIGURED constant', function (): void {
    expect(TestingError::DOUBLE_MISCONFIGURED)->toBe('TESTING.DOUBLE_MISCONFIGURED');
});

// Scenario: withMessage returns a new TestingError preserving code and context
it('returns a new instance with updated message via withMessage()', function (): void {
    $original = new TestingError('TESTING.STUB_FAILED', 'original', ['key' => 'val']);
    $updated = $original->withMessage('updated');

    expect($updated)->not->toBe($original)
        ->and($updated->message)->toBe('updated')
        ->and($updated->code)->toBe('TESTING.STUB_FAILED')
        ->and($updated->context)->toBe(['key' => 'val']);
});

// Scenario: withContext returns a new TestingError merging additional context
it('returns a new instance with merged context via withContext()', function (): void {
    $original = new TestingError('TESTING.ASSERTION_FAILED', 'msg', ['a' => 1]);
    $updated = $original->withContext(['b' => 2]);

    expect($updated)->not->toBe($original)
        ->and($updated->context)->toBe(['a' => 1, 'b' => 2])
        ->and($updated->code)->toBe('TESTING.ASSERTION_FAILED')
        ->and($updated->message)->toBe('msg');
});
