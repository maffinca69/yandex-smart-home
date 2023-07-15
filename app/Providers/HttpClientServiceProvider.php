<?php

namespace App\Providers;

use App\Infrastructure\Config\ConfigService;
use App\Infrastructure\Yandex\Client\HttpClient as YandexHttpClient;
use App\Infrastructure\Keenetic\Client\HttpClient as KeeneticHttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;
use Psr\Http\Client\ClientInterface;

class HttpClientServiceProvider extends ServiceProvider
{
    private const YANDEX_HTTP_CLIENT = 'yandex-client';
    private const KEENETIC_HTTP_CLIENT = 'keenetic-client';

    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ClientInterface::class, static function (Application $app) {
            return new Client();
        });

        $this->app->bind(YandexHttpClient::class, static function (Application $app) {
            /** @var ConfigService $configService */
            $configService = $app->get(ConfigService::class);
            $config = $configService->get(self::YANDEX_HTTP_CLIENT);

            $apiUrl = $config['api_url'] ?? null;
            if ($apiUrl === null) {
                throw new \InvalidArgumentException('Invalid config ' . self::YANDEX_HTTP_CLIENT . ': no valid \'apiUrl\' defined');
            }

            $token = $config['token'] ?? null;
            if ($token === null) {
                throw new \InvalidArgumentException('Invalid config ' . self::YANDEX_HTTP_CLIENT . ': no valid \'token\' defined');
            }

            return new YandexHttpClient(
                $app->get(ClientInterface::class),
                $apiUrl,
                $token
            );
        });

        $this->app->singleton(KeeneticHttpClient::class, static function (Application $app) {
            /** @var ConfigService $configService */
            $configService = $app->get(ConfigService::class);
            $config = $configService->get(self::KEENETIC_HTTP_CLIENT);

            $apiUrl = $config['api_url'] ?? null;
            if ($apiUrl === null) {
                throw new \InvalidArgumentException('Invalid config ' . self::KEENETIC_HTTP_CLIENT . ': no valid \'apiUrl\' defined');
            }

            $login = $config['login'] ?? null;
            if ($login === null) {
                throw new \InvalidArgumentException('Invalid config ' . self::KEENETIC_HTTP_CLIENT . ': no valid \'login\' defined');
            }

            $password = $config['password'] ?? null;
            if ($password === null) {
                throw new \InvalidArgumentException('Invalid config ' . self::KEENETIC_HTTP_CLIENT . ': no valid \'password\' defined');
            }

            $client = new Client([
                'cookies' => true
            ]);
            return new KeeneticHttpClient(
                $client,
                $apiUrl,
            );
        });
    }
}
