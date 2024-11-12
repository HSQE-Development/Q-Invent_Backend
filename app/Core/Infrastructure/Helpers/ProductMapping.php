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

        return new ProductEntity(
            id: $product->id,
            name: $product->name,
            total_quantity: $product->total_quantity,
            ubication: $product->ubication,
            observation: $product->observation,
        );
    }
}
