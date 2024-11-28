<?php

namespace App\Core\Application\UseCases\Ubication;

use App\Core\Domain\Repositories\UbicationRepositoryInterface;
use App\Core\Infrastructure\Transformers\UbicationTransformer;

class FindAllUbications
{
    protected UbicationRepositoryInterface $ubicationRepositoryInterface;

    public function __construct(UbicationRepositoryInterface $ubicationRepositoryInterface)
    {
        $this->ubicationRepositoryInterface = $ubicationRepositoryInterface;
    }

    public function execute($filters = [])
    {
        $products = $this->ubicationRepositoryInterface->index($filters);
        return UbicationTransformer::toDTOs($products);
    }
}
