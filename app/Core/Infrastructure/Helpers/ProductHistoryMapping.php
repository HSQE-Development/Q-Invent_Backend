<?php

namespace App\Core\Infrastructure\Helpers;

use App\Core\Domain\Entities\ProductHistoryEntity;
use App\Models\ProductHistory;

class ProductHistoryMapping
{
    public static function mapToEntity(ProductHistory $product): ProductHistoryEntity
    {
        return new ProductHistoryEntity(
            id: $product->id,
            people_name: $product->people_name,
            people_phone: $product->people_phone,
            people_email: $product->people_email,
            assignment_quantity: $product->assignment_quantity,
            assign_date: $product->assign_date,
            devolution_date: $product->devolution_date,
            observation: $product->observation,
        );
    }
}
