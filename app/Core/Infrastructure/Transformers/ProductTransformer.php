<?php

namespace App\Core\Infrastructure\Transformers;

use App\Core\Domain\Entities\ProductEntity;
use App\DTO\ProductDTO;

class ProductTransformer
{
    /**
     * Create a new class instance.
     */
    public static function toDTO(ProductEntity $product): ProductDTO
    {

        return new ProductDTO($product);
    }

    public static function toDTOs(array $products): array
    {
        return array_map(function (ProductEntity $products) {
            return self::toDTO($products);
        }, $products);
    }
}
