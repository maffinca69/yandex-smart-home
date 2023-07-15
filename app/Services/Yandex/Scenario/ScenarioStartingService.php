<?php

namespace App\Services\Yandex\Scenario;

use App\Infrastructure\Yandex\Client\Exception\YandexAPIHttpClientException;
use App\Infrastructure\Yandex\Client\HttpClient;
use App\Infrastructure\Yandex\Client\Request\ScenarioStartingRequest;

class ScenarioStartingService
{
    /**
     * @param HttpClient $client
     */
    public function __construct(private readonly HttpClient $client)
    {
    }

    /**
     * @param string $id
     *
     * @return void
     * @throws YandexAPIHttpClientException
     */
    public function start(string $id): void
    {
        $request = new ScenarioStartingRequest($id);

        $this->client->sendRequest($request);
    }
}
