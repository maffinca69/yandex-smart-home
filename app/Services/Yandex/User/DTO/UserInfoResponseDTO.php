<?php

namespace App\Services\Yandex\User\DTO;

class UserInfoResponseDTO
{
    /**
     * @param array<ScenarioDTO> $scenarios
     */
    public function __construct(
        private readonly array $scenarios = []
    ) {
    }

    /**
     * @return array<ScenarioDTO>
     */
    public function getScenarios(): array
    {
        return $this->scenarios;
    }
}
