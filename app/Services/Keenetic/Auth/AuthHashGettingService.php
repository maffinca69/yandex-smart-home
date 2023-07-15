<?php

namespace App\Services\Keenetic\Auth;

class AuthHashGettingService
{
    private const HASH_ALGORITHM = 'sha256';

    /**
     * @param string $login
     * @param string $password
     * @param string $realm
     * @param string $token
     *
     * @return string
     */
    public function getHash(
        string $login,
        string $password,
        string $realm,
        string $token
    ): string {
        $data = $token . md5(sprintf('%s:%s:%s', $login, $realm, $password));
        return hash(self::HASH_ALGORITHM, $data);
    }
}
