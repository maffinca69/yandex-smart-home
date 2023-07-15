<?php

namespace App\Http\Controllers;

use App\Http\Request\FormRequest\TestRequest;
use App\Services\Keenetic\Hosts\HostsGettingService;
use App\Services\Yandex\User\DTO\ScenarioDTO;
use App\Services\Yandex\User\Translator\UserInfoTranslator;
use App\Services\Yandex\User\UserInfoGettingService;

class TestController
{
    public function test(TestRequest $request, UserInfoGettingService $userInfoGettingService, HostsGettingService $hostsGettingService)
    {
//        $userInfo = $userInfoGettingService->getUserInfo();
        $hosts = $hostsGettingService->getHosts();
        return $hosts;

        return [
//            'scenarios' => array_map(static function(ScenarioDTO $scenario) {
//                return [
//                    'id' => $scenario->getId(),
//                    'name' => $scenario->getName(),
//                    'is_active' => $scenario->isActive(),
//                ];
//            }, $userInfo->getScenarios())
        ];
    }
}
