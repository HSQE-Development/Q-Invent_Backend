<?php

namespace App\Core\Domain\Entities;

class AssignmentPeopleEntity
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $phone;
    private ?int $assigned_quantity;

    public function __construct(
        ?int $id,
        string $name,
        string $email,
        string $phone,
        ?int $assigned_quantity
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->assigned_quantity = $assigned_quantity;
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
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get the value of assigned_quantity
     */
    public function getAssigned_quantity()
    {
        return $this->assigned_quantity;
    }
}
