<?php

namespace App\Core\Domain\Entities;

class ComunEntity
{
    public string $message;

    /**
     * ComunEntity constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}
