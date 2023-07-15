<?php

namespace App\Services\Keenetic\Hosts;

use App\Infrastructure\Config\ConfigService;
use App\Infrastructure\Keenetic\Client\Exception\KeeneticAPIHttpClientException;
use App\Infrastructure\Keenetic\Client\HttpClient;
use App\Infrastructure\Keenetic\Client\Request\GetHostsRequest;
use App\Services\Keenetic\Auth\DTO\SignInDTO;
use App\Services\Keenetic\Auth\Exception\KeeneticAuthException;
use App\Services\Keenetic\Auth\SignInService;
use App\Services\Keenetic\DTO\HostDTO;
use App\Services\Keenetic\Translator\HostTranslator;
use Illuminate\Http\Response;

class HostsGettingService
{
    private const KEENETIC_CONFIG = 'keenetic-client';

    /**
     * @param HttpClient $client
     * @param SignInService $signInService
     * @param ConfigService $configService
     * @param HostTranslator $hostTranslator
     */
    public function __construct(
        private readonly HttpClient $client,
        private readonly SignInService $signInService,
        private readonly ConfigService $configService,
        private readonly HostTranslator $hostTranslator
    ) {
    }

    /**
     * @param bool $secondTry
     * @return array<HostDTO>
     *
     * @throws KeeneticAPIHttpClientException
     * @throws KeeneticAuthException
     */
    public function getHosts(bool $secondTry = false): array
    {
        $request = new GetHostsRequest();

        $response = $this->client->sendRequest($request);
        if ($response->getHttpCode() === Response::HTTP_UNAUTHORIZED) {
            if ($secondTry) {
                throw new \RuntimeException('Invalid auth');
            }

            if ($this->trySignIn()) {
                return $this->getHosts(true);
            }
        }

        $hosts = [];
        foreach ($response->getResponse() as $rawHosts) {
            foreach ($rawHosts as $host) {
                $hosts[] = $this->hostTranslator->translate($host);
            }
        }

        return $hosts;
    }

    /**
     * @return bool
     *
     * @throws KeeneticAPIHttpClientException
     * @throws KeeneticAuthException
     */
    private function trySignIn(): bool
    {
        $config = $this->configService->get(self::KEENETIC_CONFIG);

        $login = $config['login'];
        $password = $config['password'];

        $signInDTO = new SignInDTO($login, $password);
        return $this->signInService->signIn($signInDTO);
    }
}
