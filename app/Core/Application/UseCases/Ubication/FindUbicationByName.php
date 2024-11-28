<?php

namespace App\Core\Application\UseCases\Ubication;

use App\Core\Domain\Repositories\UbicationRepositoryInterface;
use App\Core\Infrastructure\Transformers\UbicationTransformer;

class FindUbicationByName
{
    protected UbicationRepositoryInterface $ubicationRepositoryInterface;

    public function __construct(UbicationRepositoryInterface $ubicationRepositoryInterface)
    {
        $this->ubicationRepositoryInterface = $ubicationRepositoryInterface;
    }

    public function execute(string $name)
    {
        $product = $this->ubicationRepositoryInterface->getByName($name);
        return UbicationTransformer::toDTO($product);
    }
}
