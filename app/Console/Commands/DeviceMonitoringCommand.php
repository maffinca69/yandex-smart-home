<?php

namespace App\Console\Commands;

use App\Infrastructure\Config\ConfigService;
use App\Infrastructure\Keenetic\Client\Exception\KeeneticAPIHttpClientException;
use App\Infrastructure\Yandex\Client\Exception\YandexAPIHttpClientException;
use App\Services\Keenetic\Auth\Exception\KeeneticAuthException;
use App\Services\Keenetic\Device\DeviceStateCacheService;
use App\Services\Keenetic\Hosts\HostsGettingService;
use App\Services\Yandex\Scenario\ScenarioStartingService;
use Illuminate\Console\Command;
use Psr\SimpleCache\InvalidArgumentException;

class DeviceMonitoringCommand extends Command
{
    protected $signature = 'device:monitoring-and-processing';

    protected $description = 'Check active device and run yandex scenario';

    private array $deviceMapping = [];
    private ScenarioStartingService $scenarioStartingService;

    /**
     * @param DeviceStateCacheService $deviceStateCacheService
     * @param HostsGettingService $hostsGettingService
     * @param ConfigService $configService
     * @param ScenarioStartingService $scenarioStartingService
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws KeeneticAPIHttpClientException
     * @throws KeeneticAuthException
     * @throws YandexAPIHttpClientException
     */
    public function handle(
        DeviceStateCacheService $deviceStateCacheService,
        HostsGettingService $hostsGettingService,
        ConfigService $configService,
        ScenarioStartingService $scenarioStartingService,
    ): void {
        $this->deviceMapping = $configService->get('yandex-scenario-mapping');
        $this->scenarioStartingService = $scenarioStartingService;

        $hosts = $hostsGettingService->getHosts();
        foreach ($hosts as $host) {
            $currentState = $deviceStateCacheService->getState($host->getMac());
            if ($currentState !== $host->isActive()) {
                $this->runScenarioIfNeeded($host->getMac(), 'state', $host->isActive());
                $deviceStateCacheService->store($host->getMac(), $host->isActive());
            }
        }

        $this->line('Finish');
    }

    /**
     * @param string $mac
     * @param string $field
     * @param string $value
     *
     * @return void
     * @throws YandexAPIHttpClientException
     */
    private function runScenarioIfNeeded(string $mac, string $field, mixed $value): void
    {
        $scenarioId = $this->getScenarioByTriggerField($mac, $field, $value);
        if ($scenarioId === null) {
            return;
        }

        $this->info("Start scenario. Mac [$mac], Scenario [$scenarioId]");
        $this->scenarioStartingService->start($scenarioId);
    }

    /**
     * @param string $mac
     * @param string $field
     * @param string $value
     *
     * @return string|null
     */
    private function getScenarioByTriggerField(string $mac, string $field, mixed $value): ?string
    {
        foreach ($this->deviceMapping as $item) {
            if ($item['mac'] === $mac && $item['trigger_field'] === $field && $item['value'] === $value) {
                return $item['scenario_id'];
            }
        }

        return null;
    }
}
