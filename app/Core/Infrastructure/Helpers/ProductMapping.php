<?php

namespace App\Core\Infrastructure\Helpers;

use App\Core\Domain\Entities\ProductEntity;
use App\Models\Product;

class ProductMapping
{
    /**
     * Map a User model to a UserEntity.
     *
     * @param Product $product
     * @return ProductEntity
     */
    public static function mapToEntity(Product $product): ProductEntity
    {
        $assignmentPeople = $product->assignmentPeople()->get();
        return new ProductEntity(
            id: $product->id,
            name: $product->name,
            total_quantity: $product->total_quantity,
            quantity_type: $product->quantity_type,
            ubication: UbicationMapping::mapToEntity($product->ubication()->first()),
            observation: $product->observation,
            active: $product->active,
            assignmentPeople: $assignmentPeople->map(function ($people) {
                return AssignmentPeopleMapping::mapToEntity($people, $people->pivot);
            })->toArray(),
            quantity_available: $product->quantity_available
        );
    }
}
