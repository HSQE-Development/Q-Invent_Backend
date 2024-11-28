<?php

namespace App\Core\Domain\Entities;

use App\Core\Domain\EnumProductStatus;

class ProductEntity
{
    private ?int $id;
    private string $name;
    private int $total_quantity;
    private string $quantity_type;
    private UbicationEntity $ubication;
    private ?string $observation;
    private EnumProductStatus $active;
    private array $assignmentPeople;
    private int $quantity_available;
    private array $productHistories;

    public function __construct(
        ?int $id,
        string $name,
        int $total_quantity,
        string $quantity_type,
        UbicationEntity $ubication,
        ?string $observation,
        string $active,
        array $assignmentPeople = [],
        ?int $quantity_available,
        array $productHistories = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->total_quantity = $total_quantity;
        $this->quantity_type = $quantity_type;
        $this->ubication = $ubication;
        $this->observation = $observation;
        $this->active = EnumProductStatus::tryFrom($active);
        $this->assignmentPeople = $assignmentPeople;
        $this->quantity_available = $quantity_available ?? $total_quantity;
        $this->productHistories = $productHistories;
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

    public function getAssignmentPeople()
    {
        return $this->assignmentPeople;
    }

    /**
     * Get the value of quantity_type
     */
    public function getQuantityType()
    {
        return $this->quantity_type;
    }

    /**
     * Get the value of quantity_available
     */
    public function getQuantity_available()
    {
        return $this->quantity_available;
    }

    /**
     * Get the value of productHistories
     */
    public function getProductHistories()
    {
        return $this->productHistories;
    }
}
