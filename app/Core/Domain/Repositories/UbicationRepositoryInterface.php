<?php

namespace App\Core\Domain\Repositories;

use App\Core\Domain\Entities\UbicationEntity;

interface UbicationRepositoryInterface
{
    /**
     * Obtiene todos los registros.
     * @param array $filters Los filtros a realizar
     * @return array
     */
    public function index(array $filters = []);
    /**
     * Obtiene un registro por su ID.
     *
     * @param int $id
     * @return UbicationEntity|null
     */
    public function getById(int $id): ?UbicationEntity;

    public function getByName(string $name): ?UbicationEntity;
}
