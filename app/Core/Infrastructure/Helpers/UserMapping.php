<?php

namespace App\Core\Infrastructure\Helpers;

use App\Core\Domain\Entities\UserEntity;
use App\Models\User;

class UserMapping
{
    /**
     * Map a User model to a UserEntity.
     *
     * @param User $userModel
     * @return UserEntity
     */
    public static function mapToEntity(User $userModel): UserEntity
    {

        return new UserEntity(
            id: $userModel->id,
            firstName: $userModel->first_name,
            lastName: $userModel->last_name,
            email: $userModel->email,
            password: $userModel->password,
            activo: $userModel->activo,
            email_verified_at: $userModel->email_verified_at,
        );
    }
}
