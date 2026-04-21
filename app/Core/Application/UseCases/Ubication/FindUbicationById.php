<?php

namespace App\Core\Application\UseCases\Ubication;

use App\DTO\UbicationDTO;
use App\Core\Domain\Repositories\UbicationRepositoryInterface;
use App\Core\Infrastructure\Transformers\UbicationTransformer;

class FindUbicationById
{
    protected UbicationRepositoryInterface $ubicationRepositoryInterface;

    public function __construct(UbicationRepositoryInterface $ubicationRepositoryInterface)
    {
        $this->ubicationRepositoryInterface = $ubicationRepositoryInterface;
    }

    // Devuelve un DTO de Ubicación si se encuentra, o null si no se encuentra
    public function execute(int $id): ?UbicationDTO
    {
        $ubication = $this->ubicationRepositoryInterface->getById($id);

        if (!$ubication) {
            return null;
        }

        return UbicationTransformer::toDTO($ubication);
    }
}
