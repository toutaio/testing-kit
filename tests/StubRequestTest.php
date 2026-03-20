<?php

declare(strict_types=1);

use Touta\Aria\Runtime\Http\RequestInterface;
use Touta\Aria\Runtime\Type\HeaderMap;
use Touta\Aria\Runtime\Type\HttpBody;
use Touta\Aria\Runtime\Type\HttpMethod;
use Touta\Aria\Runtime\Type\UriPath;
use Touta\TestingKit\StubRequest;

// Scenario: default StubRequest returns branded GET, root path, empty headers, and empty body
it('creates a default GET request with branded types', function (): void {
    $request = new StubRequest();

    expect($request->method())->toBeInstanceOf(HttpMethod::class)
        ->and($request->method()->value)->toBe('GET')
        ->and($request->uri())->toBeInstanceOf(UriPath::class)
        ->and($request->uri()->value)->toBe('/')
        ->and($request->headers())->toBeInstanceOf(HeaderMap::class)
        ->and($request->headers()->value)->toBe([])
        ->and($request->body())->toBeInstanceOf(HttpBody::class)
        ->and($request->body()->value)->toBe('');
});

// Scenario: custom StubRequest preserves branded values through round-trip
it('creates a custom request with branded types', function (): void {
    $request = new StubRequest(
        method: HttpMethod::from('POST'),
        uri: UriPath::from('/api/users'),
        headers: HeaderMap::from(['Content-Type' => ['application/json']]),
        body: HttpBody::from('{"name":"test"}'),
    );

    expect($request->method()->value)->toBe('POST')
        ->and($request->uri()->value)->toBe('/api/users')
        ->and($request->headers()->value)->toBe(['Content-Type' => ['application/json']])
        ->and($request->body()->value)->toBe('{"name":"test"}');
});

// Scenario: StubRequest satisfies the runtime RequestInterface contract
it('implements RequestInterface', function (): void {
    $request = new StubRequest();

    expect($request)->toBeInstanceOf(RequestInterface::class);
});
