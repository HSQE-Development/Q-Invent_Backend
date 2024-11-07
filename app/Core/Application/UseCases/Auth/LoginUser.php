<?php

namespace App\Core\Application\UseCases\Auth;

use App\Core\Domain\Entities\AuthEntity;
use App\Core\Domain\Services\AuthServiceInterface;

class LoginUser
{
    private AuthServiceInterface $authService;
    /**
     * Create a new class instance.
     */
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function execute(string $email, string $password): AuthEntity
    {
        $credentials = [
            "email" => $email,
            "password" => $password
        ];
        return $this->authService->login($credentials);
    }
}
