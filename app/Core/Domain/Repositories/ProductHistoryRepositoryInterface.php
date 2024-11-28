<?php

namespace App\Core\Domain\Repositories;

use App\Core\Domain\Entities\ProductHistoryEntity;

interface ProductHistoryRepositoryInterface
{
    /**
     * Almacena un nuevo usuario usando Eloquent y lo mapea a la entidad de dominio.
     *
     * @param ProductHistoryEntity $user
     * @return ProductHistoryEntity
     */
    public function store(ProductHistoryEntity $user, int $productId): ProductHistoryEntity;
}
