<?php

namespace App\Core\Domain\Entities;

class AuthEntity
{
    public $access_token;
    public $token_type;
    public $expires_in;
    public $user;

    /**
     * AuthEntity constructor.
     *
     * @param string $access_token
     * @param string $token_type
     * @param int $expires_in
     * @param UserEntity $user
     */
    public function __construct($access_token, $token_type, $expires_in, $user)
    {
        $this->access_token = $access_token;
        $this->token_type = $token_type;
        $this->expires_in = $expires_in;
        $this->user = $user;
    }

    /**
     * Create an instance from an associative array.
     *
     * @param array $data
     * @return AuthEntity
     */
    public static function fromArray(array $data): AuthEntity
    {
        return new self(
            $data['access_token'] ?? '',
            $data['token_type'] ?? 'bearer',
            $data['expires_in'] ?? 3600,
            $data['user'] ?? null
        );
    }
}
