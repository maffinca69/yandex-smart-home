<?php

namespace App\Services\Keenetic\Auth\DTO;

class SignInDTO
{
    /**
     * @param string $login
     * @param string $password
     * @param string|null $realm
     * @param string|null $token
     * @param bool $isReAuth
     */
    public function __construct(
        private readonly string $login,
        private string $password,
        private ?string $realm = null,
        private ?string $token = null,
        private bool $isReAuth = false,
    ) {
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param bool $isReAuth
     */
    public function setIsReAuth(bool $isReAuth): void
    {
        $this->isReAuth = $isReAuth;
    }

    /**
     * @param string|null $realm
     */
    public function setRealm(?string $realm): void
    {
        $this->realm = $realm;
    }

    /**
     * @param string|null $token
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return bool
     */
    public function isReAuth(): bool
    {
        return $this->isReAuth;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getRealm(): ?string
    {
        return $this->realm;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }
}
