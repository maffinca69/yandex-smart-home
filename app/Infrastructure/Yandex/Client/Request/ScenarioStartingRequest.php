<?php

namespace App\Infrastructure\Yandex\Client\Request;

use App\Infrastructure\HttpClient\Request\AbstractRequest;
use App\Infrastructure\Yandex\Client\ApiMethodEnum;
use Symfony\Component\HttpFoundation\Request;

class ScenarioStartingRequest extends AbstractRequest
{
    private const ENDPOINT = ApiMethodEnum::SCENARIO_ACTION_METHOD;

    private const METHOD = Request::METHOD_POST;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $endpoint = str_replace('{id}', $id, self::ENDPOINT->value);
        parent::__construct($endpoint, self::METHOD, []);
    }
}
