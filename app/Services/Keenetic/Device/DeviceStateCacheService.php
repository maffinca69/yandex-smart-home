<?php

namespace App\Services\Keenetic\Device;

use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class DeviceStateCacheService
{
    /**
     * @param CacheInterface $cache
     */
    public function __construct(private readonly CacheInterface $cache)
    {
    }

    /**
     * @param string $mac
     *
     * @return bool|null
     * @throws InvalidArgumentException
     */
    public function getState(string $mac): ?bool
    {
        $state = $this->cache->get($mac);
        if ($state === null) {
            return null;
        }

        return (bool) $state;
    }

    /**
     * @param string $mac
     * @param bool $state
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function store(string $mac, bool $state): bool
    {
        return $this->cache->set($mac, (string)$state);
    }
}
