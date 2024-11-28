<?php

namespace App\Core\Infrastructure\Helpers;

use App\Core\Domain\Entities\ProductEntity;
use App\DTO\AssignmentPeopleDTO;
use App\DTO\ProductDTO;
use App\DTO\ProductHistoryDTO;
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
        $histories = $product->productHistories()->get();
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
            quantity_available: $product->quantity_available,
            productHistories: $histories->map(function ($history) {
                return ProductHistoryMapping::mapToEntity($history);
            })->toArray()
        );
    }

    public static function dtoToEntity(ProductDTO $product)
    {
        return new ProductEntity(
            id: $product->id,
            name: $product->name,
            total_quantity: $product->total_quantity,
            quantity_type: $product->quantity_type,
            ubication: UbicationMapping::dtoToEntity($product->ubication),
            observation: $product->observation,
            active: $product->active,
            assignmentPeople: array_map(function ($people) {
                return new AssignmentPeopleDTO($people);
            }, $product->assignmentPeople),
            quantity_available: $product->quantity_available,
            productHistories: array_map(function ($history) {
                return new ProductHistoryDTO($history);
            }, $product->productHistories)
        );
    }
}


// array_map(function ($history) {
//     return new ProductHistoryDTO($history);
// }, $entity->getProductHistories());
