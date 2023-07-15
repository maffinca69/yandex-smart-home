<?php

namespace App\Services\Yandex\User\Translator;

use App\Services\Yandex\User\DTO\UserInfoResponseDTO;

class UserInfoTranslator
{
    /**
     * @param ScenarioTranslator $scenarioTranslator
     */
    public function __construct(private ScenarioTranslator $scenarioTranslator)
    {
    }

    /**
     * @param array $response
     * @return UserInfoResponseDTO
     */
    public function translate(array $response): UserInfoResponseDTO
    {
        $scenarios = [];
        foreach ($response['scenarios'] ?? [] as $scenario) {
            $scenarios[] = $this->scenarioTranslator->translate($scenario);
        }

        return new UserInfoResponseDTO(
            scenarios: $scenarios
        );
    }
}
