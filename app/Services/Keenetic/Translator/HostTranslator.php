<?php

namespace App\Services\Keenetic\Translator;

use App\Services\Keenetic\DTO\HostDTO;

class HostTranslator
{
    /**
     * @param array $host
     * @return HostDTO
     */
    public function translate(array $host): HostDTO
    {
        return new HostDTO(
            $host['mac'],
            $host['via'],
            $host['ip'],
            $host['hostname'],
            $host['name'],
            $host['registered'],
            $host['access'],
            $host['schedule'],
            $host['priority'],
            $host['active'],
            $host['rxbytes'],
            $host['txbytes'],
            $host['uptime'],
            $host['link'] ?? '',
        );
    }
}
