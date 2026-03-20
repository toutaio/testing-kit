<?php

declare(strict_types=1);

use Touta\Aria\Runtime\Failure;
use Touta\Aria\Runtime\StructuredFailure;
use Touta\Aria\Runtime\Success;
use Touta\TestingKit\FakeResult;

// Scenario: FakeResult::success wraps value in a Success instance
it('creates a success result', function (): void {
    $result = FakeResult::success(42);

    expect($result)->toBeInstanceOf(Success::class)
        ->and($result->value())->toBe(42);
});

// Scenario: FakeResult::failure wraps error in a Failure instance
it('creates a failure result', function (): void {
    $result = FakeResult::failure('oops');

    expect($result)->toBeInstanceOf(Failure::class)
        ->and($result->error())->toBe('oops');
});

// Scenario: FakeResult::structuredFailure creates Failure with StructuredFailure payload
it('creates a structured failure result', function (): void {
    $result = FakeResult::structuredFailure('ERR_CODE', 'Something went wrong', ['key' => 'val']);

    expect($result)->toBeInstanceOf(Failure::class);

    $error = $result->error();
    expect($error)->toBeInstanceOf(StructuredFailure::class)
        ->and($error->code())->toBe('ERR_CODE')
        ->and($error->message())->toBe('Something went wrong')
        ->and($error->context())->toBe(['key' => 'val']);
});
