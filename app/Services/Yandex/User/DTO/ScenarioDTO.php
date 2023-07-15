<?php

namespace App\Services\Yandex\User\DTO;

class ScenarioDTO
{
    /**
     * @param string $id
     * @param string $name
     * @param bool $isActive
     */
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly bool $isActive,
    ) {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
    public function isActive(): bool
    {
        return $this->isActive;
    }
}
