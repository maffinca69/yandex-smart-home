<?php

namespace App\Infrastructure\Yandex\Client\Request;

use App\Infrastructure\HttpClient\Request\AbstractRequest;
use App\Infrastructure\Yandex\Client\ApiMethodEnum;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class GetUserInfoRequest extends AbstractRequest
{
    private const ENDPOINT = ApiMethodEnum::GET_USER_INFO_METHOD;

    private const METHOD = HttpRequest::METHOD_GET;

    public function __construct() {
        parent::__construct(self::ENDPOINT->value, self::METHOD, []);
    }
}
