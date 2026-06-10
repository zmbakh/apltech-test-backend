<?php

declare(strict_types=1);

namespace app\services\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

readonly class ExtractJwtUserService
{
    public function __construct(
        private string $secret,
    ) {
    }

    public function getUserIdByToken(string $token): ?int
    {
        try {
            $payload = JWT::decode($token, new Key($this->secret, 'HS256'));
        } catch (\Throwable) {
            return null;
        }

        return isset($payload->uid) ? (int) $payload->uid : null;
    }
}
