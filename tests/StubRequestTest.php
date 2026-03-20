<?php

declare(strict_types=1);

use Touta\Aria\Runtime\Http\RequestInterface;
use Touta\TestingKit\StubRequest;

it('creates a default GET request', function (): void {
    $request = new StubRequest();

    expect($request->method())->toBe('GET')
        ->and($request->uri())->toBe('/')
        ->and($request->headers())->toBe([])
        ->and($request->body())->toBe('');
});

it('creates a custom request', function (): void {
    $request = new StubRequest(
        method: 'POST',
        uri: '/api/users',
        headers: ['Content-Type' => ['application/json']],
        body: '{"name":"test"}',
    );

    expect($request->method())->toBe('POST')
        ->and($request->uri())->toBe('/api/users')
        ->and($request->headers())->toBe(['Content-Type' => ['application/json']])
        ->and($request->body())->toBe('{"name":"test"}');
});

it('implements RequestInterface', function (): void {
    $request = new StubRequest();

    expect($request)->toBeInstanceOf(RequestInterface::class);
});
