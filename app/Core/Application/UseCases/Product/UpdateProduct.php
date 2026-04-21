<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Application\UseCases\Ubication\FindUbicationById;
use App\Core\Domain\Entities\ProductEntity;
use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Infrastructure\Helpers\UbicationMapping;
use App\Core\Infrastructure\Transformers\ProductTransformer;

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
        // verificar si el producto existe, si no existe lanzar una excepción
        $existingProduct = $this->productRepositoryInterface->getById($id);

        if (!$existingProduct) {
            throw new \Exception("Producto no encontrado", 404);
        }

        $ubication = $existingProduct->getUbication();

        // Si se proporciona una nueva ubicación, verificar si existe y asignarla al producto
        if ($ubicationId !== null) {
            $existingUbication = $this->findUbicationById->execute($ubicationId);

            if (!$existingUbication) {
                throw new \Exception("No se encontro la ubicación", 404);
            }

            $ubication = UbicationMapping::dtoToEntity($existingUbication);
        }

        $productEntity = new ProductEntity(
            id: $existingProduct->getId(),
            name: $name ?? $existingProduct->getName(),
            total_quantity: $total_quantity ?? $existingProduct->getTotal_quantity(),
            quantity_type: $quantity_type ?? $existingProduct->getQuantityType(),
            ubication: $ubication,
            observation: $observation  ?? $existingProduct->getObservation(),
            active: $active  ?? $existingProduct->isActive(),
            assignmentPeople: $existingProduct->getAssignmentPeople(),
            quantity_available: $existingProduct->getQuantity_available(),
        );

        $userUpdated = $this->productRepositoryInterface->update($productEntity, $id);
        return ProductTransformer::toDTO($userUpdated);
    }
}
