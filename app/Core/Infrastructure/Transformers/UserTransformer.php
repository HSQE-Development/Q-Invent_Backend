<?php

namespace App\Core\Infrastructure\Transformers;

use App\Core\Domain\Entities\UserEntity;
use App\DTO\UserDTO;

class UserTransformer
{
    /**
     * Create a new class instance.
     */
    public static function toDTO(UserEntity $user): UserDTO
    {

        return new UserDTO($user);
    }

    public static function toDTOs(array $users): array
    {
        return array_map(function (UserEntity $user) {
            return self::toDTO($user);
        }, $users);
    }
}
