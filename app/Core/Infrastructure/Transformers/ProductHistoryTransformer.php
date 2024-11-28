<?php

namespace App\Core\Infrastructure\Transformers;

use App\Core\Domain\Entities\ProductHistoryEntity;
use App\DTO\ProductHistoryDTO;

class ProductHistoryTransformer
{
    public static function toDTO(ProductHistoryEntity $product): ProductHistoryDTO
    {

        return new ProductHistoryDTO($product);
    }

    public static function toDTOs(array $products): array
    {
        return array_map(function (ProductHistoryEntity $products) {
            return self::toDTO($products);
        }, $products);
    }
}
