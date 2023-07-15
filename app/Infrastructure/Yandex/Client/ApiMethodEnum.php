<?php

namespace App\Infrastructure\Yandex\Client;

enum ApiMethodEnum: string
{
    case GET_USER_INFO_METHOD = 'user/info';
    case SCENARIO_ACTION_METHOD = 'scenarios/{id}/actions';
    case GET_DEVICE_INFO_METHOD = 'devices/{id}';
    case DEVICE_ACTION_METHOD = 'devices/actions';
}
