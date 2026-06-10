<?php

declare(strict_types=1);

namespace app\services\Auth;

use Firebase\JWT\JWT;

readonly class IssueJwtTokenService
{
    public const int TOKEN_EXPIRES_IN = 86400;

    public function __construct(
        private string $secret,
        private string $issuer = 'product-api',
    ) {
    }

    public function issueToken(int $userId): string
    {
        $now = time();

        return JWT::encode([
            'iss' => $this->issuer,
            'iat' => $now,
            'exp' => $now + self::TOKEN_EXPIRES_IN,
            'uid' => $userId,
        ], $this->secret, 'HS256');
    }
}
