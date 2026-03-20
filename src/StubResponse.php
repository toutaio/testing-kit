<?php

declare(strict_types=1);

namespace Touta\TestingKit;

use Touta\Aria\Runtime\Http\ResponseInterface;
use Touta\Aria\Runtime\Type\HeaderMap;
use Touta\Aria\Runtime\Type\HttpBody;
use Touta\Aria\Runtime\Type\StatusCode;

final readonly class StubResponse implements ResponseInterface
{
    private StatusCode $statusCode;
    private HeaderMap $headers;
    private HttpBody $body;

    public function __construct(
        ?StatusCode $statusCode = null,
        ?HeaderMap $headers = null,
        ?HttpBody $body = null,
    ) {
        $this->statusCode = $statusCode ?? StatusCode::from(200);
        $this->headers = $headers ?? HeaderMap::from([]);
        $this->body = $body ?? HttpBody::from('');
    }

    public function statusCode(): StatusCode
    {
        return $this->statusCode;
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
