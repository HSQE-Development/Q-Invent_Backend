<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Domain\Entities\ProductEntity;
use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Infrastructure\Transformers\ProductTransformer;

class UpdateProduct
{
    protected ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    public function execute(
        int $id,
        ?string $name,
        ?int $total_quantity,
        ?string $quantity_type,
        ?string $ubication,
        ?string $observation,
        ?string $active,
    ) {
        $existingProduct = $this->productRepositoryInterface->getById($id);

        if (!$existingProduct) {
            throw new \Exception("Cliente no encontrado");
        }

        $productEntity = new ProductEntity(
            id: $existingProduct->getId(),
            name: $name ?? $existingProduct->getName(),
            total_quantity: $total_quantity ?? $existingProduct->getTotal_quantity(),
            quantity_type: $quantity_type ?? $existingProduct->getQuantityType(),
            ubication: $ubication ?? $existingProduct->getUbication(),
            observation: $observation  ?? $existingProduct->getObservation(),
            active: $active  ?? $existingProduct->isActive(),
            assignmentPeople: $existingProduct->getAssignmentPeople(),
            quantity_available: $existingProduct->getQuantity_available(),
        );

        $userUpdated = $this->productRepositoryInterface->update($productEntity, $id);
        return ProductTransformer::toDTO($userUpdated);
    }
}
