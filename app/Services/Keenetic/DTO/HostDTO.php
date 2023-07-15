<?php

namespace App\Services\Keenetic\DTO;

class HostDTO
{
    /**
     * @param string $mac
     * @param string $via
     * @param string $ip
     * @param string $hostname
     * @param string $name
     * @param bool $registered
     * @param string $access
     * @param string $schedule
     * @param int $priority
     * @param bool $active
     * @param int $rxbytes
     * @param int $txbytes
     * @param int $uptime
     * @param string $link
     */
    public function __construct(
        private readonly string $mac,
        private readonly string $via,
        private readonly string $ip,
        private readonly string $hostname,
        private readonly string $name,
        private readonly bool $registered,
        private readonly string $access,
        private readonly string $schedule,
        private readonly int $priority,
        private readonly bool $active,
        private readonly int $rxbytes,
        private readonly int $txbytes,
        private readonly int $uptime,
        private readonly string $link,
    ) {
    }

    /**
     * @return string
     */
    public function getMac(): string
    {
        return $this->mac;
    }

    /**
     * @return string
     */
    public function getVia(): string
    {
        return $this->via;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isRegistered(): bool
    {
        return $this->registered;
    }

    /**
     * @return string
     */
    public function getAccess(): string
    {
        return $this->access;
    }

    /**
     * @return string
     */
    public function getSchedule(): string
    {
        return $this->schedule;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return int
     */
    public function getRxbytes(): int
    {
        return $this->rxbytes;
    }

    /**
     * @return int
     */
    public function getTxbytes(): int
    {
        return $this->txbytes;
    }

    /**
     * @return int
     */
    public function getUptime(): int
    {
        return $this->uptime;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }
}
