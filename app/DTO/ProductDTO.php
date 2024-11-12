<?php

namespace App\DTO;

use App\Core\Domain\Entities\ProductEntity;

class ProductDTO
{
    public ?int $id;
    public string $name;
    public string $total_quantity;
    public string $ubication;
    public ?string $observation;

    public function __construct(ProductEntity $entity)
    {
        $this->id = $entity->getId();
        $this->name = $entity->getName();
        $this->total_quantity = $entity->getTotal_quantity();
        $this->ubication = $entity->getUbication();
        $this->observation = $entity->getObservation();
    }
}
