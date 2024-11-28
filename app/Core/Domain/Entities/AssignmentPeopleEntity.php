<?php

namespace App\Core\Domain\Entities;

class AssignmentPeopleEntity
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $phone;
    private ?int $assigned_quantity;
    private ?string $assign_date;
    private ?string $devolution_date;

    public function __construct(
        ?int $id,
        ?string $name,
        ?string $email,
        ?string $phone,
        ?int $assigned_quantity,
        ?string $assign_date,
        ?string $devolution_date,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->assigned_quantity = $assigned_quantity;
        $this->assign_date = $assign_date;
        $this->devolution_date = $devolution_date;
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

    /**
     * Get the value of assign_date
     */
    public function getAssign_date()
    {
        return $this->assign_date;
    }

    /**
     * Get the value of devolution_date
     */
    public function getDevolution_date()
    {
        return $this->devolution_date;
    }
}
