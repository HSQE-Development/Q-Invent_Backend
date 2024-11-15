<?php

namespace App\DTO;

use App\Core\Domain\Entities\AssignmenPeopleEntity;
use App\Core\Domain\Entities\ProductEntity;

class AssignmentPeopleDTO
{
    public ?int $id;
    public string $name;
    public string $email;
    public string $phone;
    public function __construct(AssignmenPeopleEntity $entity)
    {
        $this->id = $entity->getId();
        $this->name = $entity->getName();
        $this->email = $entity->getEmail();
        $this->phone = $entity->getPhone();
    }
}
