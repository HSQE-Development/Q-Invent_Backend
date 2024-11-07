<?php

namespace App\DTO;

use App\Core\Domain\Entities\UserEntity;

class UserDTO
{
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $activo;
    public $email_verified_at;

    public function __construct(UserEntity $userEntity)
    {
        $this->id = $userEntity->getId();
        $this->first_name = $userEntity->getFirstName();
        $this->last_name = $userEntity->getLastName();
        $this->email = $userEntity->getEmail();
        $this->activo = $userEntity->getActivo();
        $this->email_verified_at = $userEntity->getEmail_verified_at();
    }
}
