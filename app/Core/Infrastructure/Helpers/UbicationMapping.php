<?php

namespace App\Core\Infrastructure\Helpers;

use App\Core\Domain\Entities\UbicationEntity;
use App\DTO\UbicationDTO;
use App\Models\Ubication;

class UbicationMapping
{
    public static function mapToEntity(Ubication $ubication)
    {
        return new UbicationEntity(
            id: $ubication->id,
            name: $ubication->name
        );
    }
    public static function dtoToEntity(UbicationDTO $ubication)
    {
        return new UbicationEntity(
            id: $ubication->id,
            name: $ubication->name
        );
    }
}
