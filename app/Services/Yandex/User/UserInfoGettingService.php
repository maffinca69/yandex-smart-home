<?php

namespace App\Services\Yandex\User;

use App\Infrastructure\Yandex\Client\Exception\YandexAPIHttpClientException;
use App\Infrastructure\Yandex\Client\HttpClient;
use App\Infrastructure\Yandex\Client\Request\GetUserInfoRequest;
use App\Services\Yandex\User\DTO\UserInfoResponseDTO;
use App\Services\Yandex\User\Translator\UserInfoTranslator;

class UserInfoGettingService
{
    /**
     * @param HttpClient $client
     * @param UserInfoTranslator $userInfoTranslator
     */
    public function __construct(
        private readonly HttpClient $client,
        private readonly UserInfoTranslator $userInfoTranslator
    ) {
    }

    /**
     * @return UserInfoResponseDTO
     * @throws YandexAPIHttpClientException
     */
    public function getUserInfo(): UserInfoResponseDTO
    {
        $request = new GetUserInfoRequest();
        $response = $this->client->sendRequest($request);

        return $this->userInfoTranslator->translate($response);
    }
}
