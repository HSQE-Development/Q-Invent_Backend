<?php

namespace App\DTO;

use App\Core\Domain\Entities\ProductHistoryEntity;
use App\Core\Infrastructure\Transformers\ProductTransformer;

class ProductHistoryDTO
{
    public ?int $id;
    public ?string $people_name;
    public ?string $people_phone;
    public ?string $people_email;
    public ?int $assignment_quantity;
    public ?string $assign_date;
    public ?string $devolution_date;
    public ?string $observation;

    public function __construct(ProductHistoryEntity $entity)
    {
        $this->id = $entity->getId();
        $this->people_name = $entity->getPeople_name();
        $this->people_phone = $entity->getPeople_phone();
        $this->people_email = $entity->getPeople_email();
        $this->assignment_quantity = $entity->getAssignment_quantity();
        $this->assign_date = $entity->getAssign_date();
        $this->devolution_date = $entity->getDevolution_date();
        $this->observation = $entity->getObservation();
    }
}
