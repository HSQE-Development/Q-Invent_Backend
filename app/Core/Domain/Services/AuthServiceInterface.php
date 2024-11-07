<?php

namespace App\Core\Domain\Services;

use App\Core\Domain\Entities\AuthEntity;
use App\Core\Domain\Entities\ComunEntity;
use App\Core\Domain\Entities\UserEntity;

interface AuthServiceInterface
{
    /**
     *Devuelve el JWT
     * @param string $email
     * @param string $password
     * @return AuthEntity
     */
    public function login(array $credentials): ?AuthEntity;

    /**
     * Inautenticar el usaurio en sesion
     * @return ComunEntity
     */
    public function logout(): ?ComunEntity;
    /**
     * Informacion del usuario autenticado
     * @return UserEntity
     */
    public function me(): ?UserEntity;
}
