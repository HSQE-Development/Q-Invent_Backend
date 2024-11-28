<?php

namespace App\Core\Domain\Entities;

class UserEntity
{
    private ?int $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private ?string $password;
    private bool $is_superuser;
    private bool $activo;
    private ?string $email_verified_at;


    public function __construct(
        ?int $id,
        string $firstName,
        string $lastName,
        string $email,
        ?string $password,
        bool $activo,
        ?string $email_verified_at = null,
        bool $is_superuser
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->activo = $activo;
        $this->email_verified_at = $email_verified_at;
        $this->is_superuser = $is_superuser;
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
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of first_name
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of first_name
     *
     */
    public function setFirstName($first_name)
    {
        $this->firstName = $first_name;
    }

    /**
     * Get the value of last_name
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of last_name
     *
     */
    public function setLastName($last_name)
    {
        $this->lastName = $last_name;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get the value of activo
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set the value of activo
     *
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * Get the value of email_verified_at
     */
    public function getEmail_verified_at()
    {
        return $this->email_verified_at;
    }

    /**
     * Set the value of email_verified_at
     *
     */
    public function setEmail_verified_at($email_verified_at)
    {
        $this->email_verified_at = $email_verified_at;
    }

    /**
     * Get the value of is_superuser
     */
    public function getIs_superuser()
    {
        return $this->is_superuser;
    }
}
