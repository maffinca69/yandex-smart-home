<?php

namespace App\Infrastructure\Keenetic\Client\Response;

class KeeneticResponseDTO
{
    /**
     * @param array $response
     * @param array $headers
     * @param int $httpCode
     */
    public function __construct(
        private readonly array $response,
        private readonly array $headers,
        private readonly int $httpCode,
    ) {
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
