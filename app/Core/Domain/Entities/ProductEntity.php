<?php

namespace App\Core\Domain\Entities;

enum ProductStatus: string
{
    case Activo = "A";
    case Inactivo = "I";
}
class ProductEntity
{
    private ?int $id;
    private string $name;
    private int $total_quantity;
    private string $quantity_type;
    private string $ubication;
    private ?string $observation;
    private ProductStatus $active;
    private array $assignments;

    public function __construct(
        ?int $id,
        string $name,
        int $total_quantity,
        string $quantity_type,
        string $ubication,
        ?string $observation,
        string $active,
        array $assignments = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->total_quantity = $total_quantity;
        $this->quantity_type = $quantity_type;
        $this->ubication = $ubication;
        $this->observation = $observation;
        $this->active = ProductStatus::tryFrom($active);
        $this->assignments = $assignments;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of total_quantity
     */
    public function getTotal_quantity()
    {
        return $this->total_quantity;
    }

    /**
     * Get the value of ubication
     */
    public function getUbication()
    {
        return $this->ubication;
    }

    /**
     * Get the value of observation
     */
    public function getObservation()
    {
        return $this->observation;
    }

    public function isActive()
    {
        return $this->active->value;
    }

    public function getAssignments()
    {
        return $this->assignments;
    }

    /**
     * Get the value of quantity_type
     */
    public function getQuantityType()
    {
        return $this->quantity_type;
    }
}
