<?php

namespace App\Core\Domain\Entities;

class AssignmentPeopleEntity
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $phone;

    public function __construct(
        ?int $id,
        string $name,
        string $email,
        string $phone,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
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
}
