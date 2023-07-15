<?php

namespace App\Infrastructure\Yandex\Client;

use App\Infrastructure\HttpClient\Request\AbstractRequest;
use App\Infrastructure\Yandex\Client\Exception\YandexAPIHttpClientException;
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
     * @param string $token
     */
    public function __construct(
        private readonly ClientInterface $client,
        private readonly string $host,
        private readonly string $token
    ) {
    }

    /**
     * @param AbstractRequest $request
     *
     * @return array
     *
     * @throws YandexAPIHttpClientException
     */
    public function sendRequest(AbstractRequest $request): array
    {
        $method = $request->getMethod();
        $url = $this->host . '/' . $request->getEndpoint();

        $requestParams = $request->getParams();

        $options = [
            RequestOptions::HEADERS => array_merge(self::REQUEST_HEADERS, [
                'Authorization' => "Bearer $this->token"
            ])
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
        } catch (\Throwable $e) {
            $message = 'Yandex API request error';
            Log::error($message, [
                'url' => $url,
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);

            throw new YandexAPIHttpClientException($message);
        }

        $rawResponse = $response->getBody()->getContents();
        $decodedResponse = json_decode($rawResponse, true);

        Log::debug("Response [{$method} {$url}]:", ['response' => $decodedResponse ?: $rawResponse]);
        return $decodedResponse;
    }
}
