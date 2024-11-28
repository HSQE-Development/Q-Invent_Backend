<?php

namespace App\DTO;

use App\Core\Domain\Entities\AssignmentPeopleEntity;

class AssignmentPeopleDTO
{
    public ?int $id;
    public string $name;
    public string $email;
    public string $phone;
    public ?int $assigned_quantity;
    public ?string $assign_date;
    public ?string $devolution_date;

    public function __construct(AssignmentPeopleEntity $entity)
    {
        $this->id = $entity->getId();
        $this->name = $entity->getName();
        $this->email = $entity->getEmail();
        $this->phone = $entity->getPhone();
        $this->assigned_quantity = $entity->getAssigned_quantity();
        $this->assign_date = $entity->getAssign_date();
        $this->devolution_date = $entity->getDevolution_date();
    }
}
