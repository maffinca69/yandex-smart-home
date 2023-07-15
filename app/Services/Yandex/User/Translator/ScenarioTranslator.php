<?php

namespace App\Services\Yandex\User\Translator;

use App\Services\Yandex\User\DTO\ScenarioDTO;

class ScenarioTranslator
{
    /**
     * @param array $scenario
     * @return ScenarioDTO
     */
    public function translate(array $scenario): ScenarioDTO
    {
        return new ScenarioDTO(
            id: $scenario['id'],
            name: $scenario['name'],
            isActive: (bool) $scenario['is_active'],
        );
    }
}
