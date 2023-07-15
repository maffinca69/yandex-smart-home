<?php

namespace App\Infrastructure\Keenetic\Client\Request;

use App\Infrastructure\HttpClient\Request\AbstractRequest;
use App\Infrastructure\Keenetic\Client\ApiMethodEnum;
use Illuminate\Http\Request;

class AuthRequest extends AbstractRequest
{
    private const ENDPOINT = ApiMethodEnum::AUTH_METHOD;

    /**
     * @param string|null $login
     * @param string|null $password
     * @param string $method
     */
    public function __construct(?string $login = null, ?string $password = null, string $method = Request::METHOD_GET)
    {
        if (isset($login, $password)) {
            $params = [
                'login' => $login,
                'password' => $password,
            ];
        }

        parent::__construct(self::ENDPOINT->value, $method, $params ?? []);
    }
}
