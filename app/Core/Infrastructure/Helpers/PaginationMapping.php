<?php

namespace App\Core\Infrastructure\Helpers;

use App\Core\Domain\Entities\PaginationEntity;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationMapping
{
    /**
     * Mapea los productos paginados a la entidad de paginación.
     *
     * @param array $mappedProducts
     * @param LengthAwarePaginator $productPaginator
     * @return PaginationEntity
     */
    public static function mapToEntity(array $mappedProducts, LengthAwarePaginator $productPaginator): PaginationEntity
    {
        return new PaginationEntity(
            $mappedProducts,
            $productPaginator->total(),
            $productPaginator->count(),
            $productPaginator->perPage(),
            $productPaginator->currentPage(),
            $productPaginator->lastPage(),
            $productPaginator->nextPageUrl(),
            $productPaginator->previousPageUrl()
        );
    }
}
