<?php

declare(strict_types=1);

namespace Touta\TestingKit;

/**
 * Domain-typed error for the testing-kit package.
 *
 * Used in Result<T, TestingError> return types within testing-kit.
 */
final readonly class TestingError
{
    public const STUB_FAILED = 'TESTING.STUB_FAILED';
    public const ASSERTION_FAILED = 'TESTING.ASSERTION_FAILED';
    public const DOUBLE_MISCONFIGURED = 'TESTING.DOUBLE_MISCONFIGURED';

    /**
     * @param array<string, mixed> $context
     */
    public function __construct(
        public string $code,
        public string $message,
        public array $context = [],
    ) {}

    public function withMessage(string $message): self
    {
        return new self($this->code, $message, $this->context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function withContext(array $context): self
    {
        return new self($this->code, $this->message, array_merge($this->context, $context));
    }
}
