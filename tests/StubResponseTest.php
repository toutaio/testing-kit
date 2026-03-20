<?php

declare(strict_types=1);

use Touta\Aria\Runtime\Http\ResponseInterface;
use Touta\TestingKit\StubResponse;

it('creates a default 200 response', function (): void {
    $response = new StubResponse();

    expect($response->statusCode())->toBe(200)
        ->and($response->headers())->toBe([])
        ->and($response->body())->toBe('');
});

it('creates a custom response', function (): void {
    $response = new StubResponse(
        statusCode: 404,
        headers: ['X-Foo' => ['bar']],
        body: 'not found',
    );

    expect($response->statusCode())->toBe(404)
        ->and($response->headers())->toBe(['X-Foo' => ['bar']])
        ->and($response->body())->toBe('not found');
});

it('implements ResponseInterface', function (): void {
    $response = new StubResponse();

    expect($response)->toBeInstanceOf(ResponseInterface::class);
});
