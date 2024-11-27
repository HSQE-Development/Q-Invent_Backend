<?php

namespace App\Core\Application\UseCases\Auth;

use App\Core\Domain\Entities\ComunEntity;
use App\Core\Domain\Services\AuthServiceInterface;

class LogoutUser
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function execute(): ComunEntity
    {
        return $this->authService->logout();
    }
}
