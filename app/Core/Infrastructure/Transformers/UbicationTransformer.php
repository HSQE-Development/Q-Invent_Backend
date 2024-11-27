<?php

namespace App\Core\Infrastructure\Transformers;

use App\Core\Domain\Entities\UbicationEntity;
use App\DTO\UbicationDTO;

class UbicationTransformer
{
    public static function toDTO(UbicationEntity $ubication): UbicationDTO
    {
        return new UbicationDTO($ubication);
    }

    public static function toDTOs(array $ubications): array
    {
        return array_map(function (UbicationEntity $ubications) {
            return self::toDTO($ubications);
        }, $ubications);
    }
}
