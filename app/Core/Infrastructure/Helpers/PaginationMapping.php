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
     * @param array $mappedData
     * @param LengthAwarePaginator $productPaginator
     * @return PaginationEntity
     */
    public static function mapToEntity(array $mappedData, LengthAwarePaginator $paginatorProps): PaginationEntity
    {
        return new PaginationEntity(
            $mappedData,
            $paginatorProps->total(),
            $paginatorProps->count(),
            $paginatorProps->perPage(),
            $paginatorProps->currentPage(),
            $paginatorProps->lastPage(),
            $paginatorProps->nextPageUrl(),
            $paginatorProps->previousPageUrl()
        );
    }
}
