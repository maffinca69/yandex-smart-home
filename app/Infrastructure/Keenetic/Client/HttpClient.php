<?php

namespace App\Infrastructure\Keenetic\Client;

use App\Infrastructure\HttpClient\Request\AbstractRequest;
use App\Infrastructure\Keenetic\Client\Exception\KeeneticAPIHttpClientException;
use App\Infrastructure\Keenetic\Client\Response\KeeneticResponseDTO;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;


class HttpClient
{
    private const REQUEST_HEADERS = [
        'Accept-Encoding' => 'gzip,deflate',
    ];

    /**
     * @param ClientInterface $client
     * @param string $host
     */
    public function __construct(
        private readonly ClientInterface $client,
        private readonly string $host,
    ) {
    }

    /**
     * @param AbstractRequest $request
     *
     * @return KeeneticResponseDTO
     * @throws KeeneticAPIHttpClientException
     */
    public function sendRequest(AbstractRequest $request): KeeneticResponseDTO
    {
        $method = $request->getMethod();
        $url = $this->host . '/' . $request->getEndpoint();

        $requestParams = $request->getParams();

        $options = [
            RequestOptions::HEADERS => self::REQUEST_HEADERS
        ];

        switch ($method) {
            case HttpRequest::METHOD_GET:
                $options[RequestOptions::QUERY] = $requestParams;
                break;
            case HttpRequest::METHOD_POST:
                $options[RequestOptions::JSON] = $requestParams;
                break;
        }

        Log::debug("Request[{$method} {$url}]:", [
            'params' => $requestParams,
            'options' => $options,
        ]);

        try {
            $response = $this->client->request($method, $url, $options);
        } catch (ClientException $e) {
            return new KeeneticResponseDTO(
                response: [],
                headers: $e->getResponse()->getHeaders(),
                httpCode: $e->getCode()
            );
        }

        $rawResponse = $response->getBody()->getContents();
        $decodedResponse = json_decode($rawResponse, true);

        Log::debug("Response [{$method} {$url}]:", ['response' => $decodedResponse ?: $rawResponse]);
        return new KeeneticResponseDTO(
            response: $decodedResponse ?: [],
            headers: $response->getHeaders(),
            httpCode: $response->getStatusCode()
        );
    }
}
