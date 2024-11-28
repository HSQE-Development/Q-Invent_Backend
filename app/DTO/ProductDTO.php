<?php

namespace App\DTO;

use App\Core\Domain\Entities\ProductEntity;

class ProductDTO
{
    public ?int $id;
    public string $name;
    public int $total_quantity;
    public string $quantity_type;
    public UbicationDTO $ubication;
    public ?string $observation;
    public string $active;
    public array $assignmentPeople;
    public int $quantity_available;
    public array $productHistories;

    public function __construct(ProductEntity $entity)
    {
        $this->id = $entity->getId();
        $this->name = $entity->getName();
        $this->total_quantity = $entity->getTotal_quantity();
        $this->quantity_type = $entity->getQuantityType();
        $this->ubication = new UbicationDTO($entity->getUbication());
        $this->observation = $entity->getObservation();
        $this->active = $entity->isActive();
        $this->quantity_available = $entity->getQuantity_available();
        $this->assignmentPeople = array_map(function ($people) {
            return new AssignmentPeopleDTO($people);
        }, $entity->getAssignmentPeople());
        $this->productHistories = array_map(function ($history) {
            return new ProductHistoryDTO($history);
        }, $entity->getProductHistories());
    }
}
