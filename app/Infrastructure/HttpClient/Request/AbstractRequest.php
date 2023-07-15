<?php

namespace App\Infrastructure\HttpClient\Request;

abstract class AbstractRequest
{
    /**
     * @param string $endpoint
     * @param string $method
     * @param array $params
     */
    public function __construct(
        private readonly string $endpoint,
        private readonly string $method,
        private readonly array  $params
    ) {
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
