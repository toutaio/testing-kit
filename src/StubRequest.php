<?php

declare(strict_types=1);

namespace Touta\TestingKit;

use Touta\Aria\Runtime\Http\RequestInterface;

final readonly class StubRequest implements RequestInterface
{
    /**
     * @param array<string, list<string>> $headers
     */
    public function __construct(
        private string $method = 'GET',
        private string $uri = '/',
        private array $headers = [],
        private string $body = '',
    ) {}

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): string
    {
        return $this->uri;
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
