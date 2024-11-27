<?php

namespace App\DTO;

use App\Core\Domain\Entities\UbicationEntity;

class UbicationDTO
{
    public ?int $id;
    public string $name;

    public function __construct(UbicationEntity $ubication)
    {
        $this->id = $ubication->getId();
        $this->name = $ubication->getName();
    }
}
