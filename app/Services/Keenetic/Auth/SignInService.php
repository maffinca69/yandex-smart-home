<?php

namespace App\Services\Keenetic\Auth;

use App\Infrastructure\Keenetic\Client\Exception\KeeneticAPIHttpClientException;
use App\Infrastructure\Keenetic\Client\HttpClient;
use App\Infrastructure\Keenetic\Client\Request\AuthRequest;
use App\Services\Keenetic\Auth\DTO\SignInDTO;
use App\Services\Keenetic\Auth\Exception\KeeneticAuthException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class SignInService
{
    /**
     * @param HttpClient $client
     * @param AuthHashGettingService $authHashGettingService
     */
    public function __construct(
        private readonly HttpClient $client,
        private readonly AuthHashGettingService $authHashGettingService
    ) {
    }

    /**
     * @param SignInDTO $signInDTO
     * @return bool
     * @throws KeeneticAPIHttpClientException|KeeneticAuthException
     */
    public function signIn(SignInDTO $signInDTO): bool
    {
        $login = $signInDTO->getLogin();
        $password = $signInDTO->getPassword();
        $method = $signInDTO->isReAuth() ? Request::METHOD_POST : Request::METHOD_GET;

        $request = new AuthRequest($login, $password, $method);
        $response = $this->client->sendRequest($request);

        if ($response->getHttpCode() === HttpResponse::HTTP_BAD_REQUEST) {
            throw new KeeneticAuthException('Invalid data');
        }

        if ($response->getHttpCode() === HttpResponse::HTTP_UNAUTHORIZED) {
            if ($signInDTO->isReAuth()) {
                throw new KeeneticAuthException('Invalid password hash or credentials');
            }

            $headers = $response->getHeaders();

            $signInDTO->setToken($headers['X-NDM-Challenge'][0]);
            $signInDTO->setRealm($headers['X-NDM-Realm'][0]);
            $signInDTO->setIsReAuth(true);
            $signInDTO->setPassword($this->authHashGettingService->getHash(
                $login,
                $password,
                $signInDTO->getRealm(),
                $signInDTO->getToken(),
            ));

            return $this->signIn($signInDTO);
        }

        return $response->getHttpCode() === HttpResponse::HTTP_OK;
    }
}
