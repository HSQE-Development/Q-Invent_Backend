<?php

namespace App\Core\Domain\Entities;

class ProductEntity
{
    private ?int $id;
    private string $name;
    private string $total_quantity;
    private string $ubication;
    private ?string $observation;

    public function __construct(
        ?int $id,
        string $name,
        string $total_quantity,
        string $ubication,
        ?string $observation,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->total_quantity = $total_quantity;
        $this->ubication = $ubication;
        $this->observation = $observation;
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
}
