<?php

declare(strict_types=1);

namespace Touta\TestingKit;

use Touta\Aria\Runtime\Http\ResponseInterface;

final readonly class StubResponse implements ResponseInterface
{
    /**
     * @param array<string, list<string>> $headers
     */
    public function __construct(
        public int $statusCode = 200,
        public array $headers = [],
        public string $body = '',
    ) {}

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array<string, list<string>>
     */
    public function headers(): array
    {
        return $this->headers;
    }

    public function body(): string
    {
        return $this->body;
    }
}
