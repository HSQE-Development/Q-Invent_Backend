<?php

namespace App\Core\Application\UseCases\Ubication;

use App\Core\Domain\Repositories\UbicationRepositoryInterface;
use App\Core\Infrastructure\Transformers\UbicationTransformer;

class FindUbicationById
{
    protected UbicationRepositoryInterface $ubicationRepositoryInterface;

    public function __construct(UbicationRepositoryInterface $ubicationRepositoryInterface)
    {
        $this->ubicationRepositoryInterface = $ubicationRepositoryInterface;
    }

    public function execute(int $id)
    {
        $product = $this->ubicationRepositoryInterface->getById($id);
        return UbicationTransformer::toDTO($product);
    }
}
