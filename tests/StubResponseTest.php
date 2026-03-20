<?php

declare(strict_types=1);

use Touta\Aria\Runtime\Http\ResponseInterface;
use Touta\Aria\Runtime\Type\HeaderMap;
use Touta\Aria\Runtime\Type\HttpBody;
use Touta\Aria\Runtime\Type\StatusCode;
use Touta\TestingKit\StubResponse;

// Scenario: default StubResponse returns branded 200 status, empty headers, and empty body
it('creates a default 200 response with branded types', function (): void {
    $response = new StubResponse();

    expect($response->statusCode())->toBeInstanceOf(StatusCode::class)
        ->and($response->statusCode()->value)->toBe(200)
        ->and($response->headers())->toBeInstanceOf(HeaderMap::class)
        ->and($response->headers()->value)->toBe([])
        ->and($response->body())->toBeInstanceOf(HttpBody::class)
        ->and($response->body()->value)->toBe('');
});

// Scenario: custom StubResponse preserves branded values through round-trip
it('creates a custom response with branded types', function (): void {
    $response = new StubResponse(
        statusCode: StatusCode::from(404),
        headers: HeaderMap::from(['X-Foo' => ['bar']]),
        body: HttpBody::from('not found'),
    );

    expect($response->statusCode()->value)->toBe(404)
        ->and($response->headers()->value)->toBe(['X-Foo' => ['bar']])
        ->and($response->body()->value)->toBe('not found');
});

// Scenario: StubResponse satisfies the runtime ResponseInterface contract
it('implements ResponseInterface', function (): void {
    $response = new StubResponse();

    expect($response)->toBeInstanceOf(ResponseInterface::class);
});
