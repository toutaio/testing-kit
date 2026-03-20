<?php

declare(strict_types=1);

namespace Touta\TestingKit;

use Touta\Aria\Runtime\Failure;
use Touta\Aria\Runtime\StructuredFailure;
use Touta\Aria\Runtime\Success;

final class FakeResult
{
    /**
     * @template T
     *
     * @param T $value
     *
     * @return Success<T>
     */
    public static function success(mixed $value): Success
    {
        return Success::of($value);
    }

    /**
     * @template E
     *
     * @param E $error
     *
     * @return Failure<E>
     */
    public static function failure(mixed $error): Failure
    {
        return Failure::from($error);
    }

    /**
     * @param array<string, mixed> $context
     *
     * @return Failure<StructuredFailure>
     */
    public static function structuredFailure(string $code, string $message, array $context = []): Failure
    {
        return Failure::from(new StructuredFailure($code, $message, $context));
    }
}
