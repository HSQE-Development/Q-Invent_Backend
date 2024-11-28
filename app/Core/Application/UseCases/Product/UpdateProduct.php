<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Application\UseCases\Ubication\FindUbicationById;
use App\Core\Domain\Entities\ProductEntity;
use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Infrastructure\Helpers\UbicationMapping;
use App\Core\Infrastructure\Transformers\ProductTransformer;
use App\Core\Infrastructure\Transformers\UbicationTransformer;

class UpdateProduct
{
    protected ProductRepositoryInterface $productRepositoryInterface;
    protected FindUbicationById $findUbicationById;
    public function __construct(ProductRepositoryInterface $productRepositoryInterface, FindUbicationById $findUbicationById)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->findUbicationById = $findUbicationById;
    }

    public function execute(
        int $id,
        ?string $name,
        ?int $total_quantity,
        ?string $quantity_type,
        ?int $ubicationId,
        ?string $observation,
        ?string $active,
    ) {

        $existingUbication = null;
        if ($ubicationId)
            $existingUbication = $this->findUbicationById->execute($ubicationId);

        if (!$existingUbication) {
            throw new \Exception("No se encontro la ubicación", 404);
        }

        $existingProduct = $this->productRepositoryInterface->getById($id);

        if (!$existingProduct) {
            throw new \Exception("Cliente no encontrado", 404);
        }

        $productEntity = new ProductEntity(
            id: $existingProduct->getId(),
            name: $name ?? $existingProduct->getName(),
            total_quantity: $total_quantity ?? $existingProduct->getTotal_quantity(),
            quantity_type: $quantity_type ?? $existingProduct->getQuantityType(),
            ubication: UbicationMapping::dtoToEntity($existingUbication) ?? $existingProduct->getUbication(),
            observation: $observation  ?? $existingProduct->getObservation(),
            active: $active  ?? $existingProduct->isActive(),
            assignmentPeople: $existingProduct->getAssignmentPeople(),
            quantity_available: $existingProduct->getQuantity_available(),
        );

        $userUpdated = $this->productRepositoryInterface->update($productEntity, $id);
        return ProductTransformer::toDTO($userUpdated);
    }
}
