<?php

namespace App\DTO;

use App\Core\Domain\Entities\AssignmentPeopleEntity;
use App\Core\Domain\Entities\ProductEntity;

class AssignmentPeopleDTO
{
    public ?int $id;
    public string $name;
    public string $email;
    public string $phone;
    public ?int $assigned_quantity;

    public function __construct(AssignmentPeopleEntity $entity)
    {
        $this->id = $entity->getId();
        $this->name = $entity->getName();
        $this->email = $entity->getEmail();
        $this->phone = $entity->getPhone();
        $this->assigned_quantity = $entity->getAssigned_quantity();
    }
}
