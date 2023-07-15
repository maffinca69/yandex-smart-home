<?php

namespace App\Infrastructure\Keenetic\Client;

enum ApiMethodEnum: string
{
    case GET_HOSTS_METHOD = 'rci/show/ip/hotspot';
    case GET_DEVICES_BY_ARP_METHOD = 'rci/show/ip/arp';
    case AUTH_METHOD = 'auth';
}
