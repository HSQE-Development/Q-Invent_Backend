<?php

namespace App\Core\Domain\Entities;

class ProductHistoryEntity
{
    private ?int $id;
    private string $people_name;
    private string $people_phone;
    private string $people_email;
    private int $assignment_quantity;
    private string $assign_date;
    private string $devolution_date;
    private string $observation;

    public function __construct(
        ?int $id,
        string $people_name,
        string $people_phone,
        string $people_email,
        int $assignment_quantity,
        string $assign_date,
        string $devolution_date,
        string $observation,
    ) {
        $this->id = $id;
        $this->people_name = $people_name;
        $this->people_phone = $people_phone;
        $this->people_email = $people_email;
        $this->assignment_quantity = $assignment_quantity;
        $this->assign_date = $assign_date;
        $this->devolution_date = $devolution_date;
        $this->observation = $observation;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of people_name
     */
    public function getPeople_name()
    {
        return $this->people_name;
    }

    /**
     * Get the value of people_phone
     */
    public function getPeople_phone()
    {
        return $this->people_phone;
    }

    /**
     * Get the value of people_email
     */
    public function getPeople_email()
    {
        return $this->people_email;
    }

    /**
     * Get the value of assignment_quantity
     */
    public function getAssignment_quantity()
    {
        return $this->assignment_quantity;
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

    /**
     * Get the value of observation
     */
    public function getObservation()
    {
        return $this->observation;
    }
}
