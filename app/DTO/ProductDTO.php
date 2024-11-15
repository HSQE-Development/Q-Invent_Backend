<?php

namespace App\DTO;

use App\Core\Domain\Entities\ProductEntity;

class ProductDTO
{
    public ?int $id;
    public string $name;
    public int $total_quantity;
    public string $quantity_type;
    public string $ubication;
    public ?string $observation;
    public string $active;

    public function __construct(ProductEntity $entity)
    {
        $this->id = $entity->getId();
        $this->name = $entity->getName();
        $this->total_quantity = $entity->getTotal_quantity();
        $this->quantity_type = $entity->getQuantityType();
        $this->ubication = $entity->getUbication();
        $this->observation = $entity->getObservation();
        $this->active = $entity->isActive();
    }
}
