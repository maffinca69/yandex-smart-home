<?php

namespace App\Infrastructure\Keenetic\Client\Request;

use App\Infrastructure\HttpClient\Request\AbstractRequest;
use App\Infrastructure\Keenetic\Client\ApiMethodEnum;
use Symfony\Component\HttpFoundation\Request;

class GetHostsRequest extends AbstractRequest
{
    private const ENDPOINT = ApiMethodEnum::GET_HOSTS_METHOD;

    private const METHOD = Request::METHOD_GET;

    /**
     * @param string|null $mac
     */
    public function __construct(?string $mac = null)
    {
        $params = [];

        if ($mac !== null) {
            $params['mac'] = $mac;
        }

        parent::__construct(self::ENDPOINT->value, self::METHOD, $params);
    }
}
