<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Entities\UbicationEntity;
use App\Core\Domain\Repositories\UbicationRepositoryInterface;
use App\Core\Infrastructure\Helpers\UbicationMapping;
use App\Models\Ubication;

class EloquentUbicationRepository implements UbicationRepositoryInterface
{
    public function index($filters = [])
    {
        $ubications = Ubication::query()->get();
        return collect($ubications)->map(function ($ubication) {
            return UbicationMapping::mapToEntity($ubication);
        })->toArray();
    }

    public function getById($id): ?UbicationEntity
    {
        $eloquentUbication =  Ubication::find($id);
        return $eloquentUbication ? UbicationMapping::mapToEntity($eloquentUbication) : null;
    }

    public function getByName(string $name): ?UbicationEntity
    {
        $eloquentUbication = Ubication::whereRaw("LOWER(name) = ?", [strtolower($name)])->first();
        return $eloquentUbication ? UbicationMapping::mapToEntity($eloquentUbication) : null;
    }
}
