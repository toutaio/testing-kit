<?php

declare(strict_types=1);

namespace Touta\TestingKit;

use Touta\Aria\Runtime\Http\RequestInterface;
use Touta\Aria\Runtime\Type\HeaderMap;
use Touta\Aria\Runtime\Type\HttpBody;
use Touta\Aria\Runtime\Type\HttpMethod;
use Touta\Aria\Runtime\Type\UriPath;

final readonly class StubRequest implements RequestInterface
{
    private HttpMethod $method;
    private UriPath $uri;
    private HeaderMap $headers;
    private HttpBody $body;

    public function __construct(
        ?HttpMethod $method = null,
        ?UriPath $uri = null,
        ?HeaderMap $headers = null,
        ?HttpBody $body = null,
    ) {
        $this->method = $method ?? HttpMethod::from('GET');
        $this->uri = $uri ?? UriPath::from('/');
        $this->headers = $headers ?? HeaderMap::from([]);
        $this->body = $body ?? HttpBody::from('');
    }

    public function method(): HttpMethod
    {
        return $this->method;
    }

    public function uri(): UriPath
    {
        return $this->uri;
    }

    public function headers(): HeaderMap
    {
        return $this->headers;
    }

    public function body(): HttpBody
    {
        return $this->body;
    }
}
