<?php

namespace App\Core\Infrastructure\Helpers;

use App\Core\Domain\Entities\ProductHistoryEntity;
use App\DTO\ProductHistoryDTO;
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

    public static function dtoToEntity(ProductHistoryDTO $productHistory)
    {
        return new ProductHistoryEntity(
            id: $productHistory->id,
            people_name: $productHistory->people_name,
            people_phone: $productHistory->people_phone,
            people_email: $productHistory->people_email,
            assignment_quantity: $productHistory->assignment_quantity,
            assign_date: $productHistory->assign_date,
            devolution_date: $productHistory->devolution_date,
            observation: $productHistory->observation,
        );
    }
}
