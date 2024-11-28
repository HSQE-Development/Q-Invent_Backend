<?php

namespace App\Core\Application\UseCases\ProductHistory;

use App\Core\Domain\Entities\ProductEntity;
use App\Core\Domain\Entities\ProductHistoryEntity;
use App\Core\Domain\Repositories\ProductHistoryRepositoryInterface;
use App\Core\Infrastructure\Transformers\ProductHistoryTransformer;

class CreateProductHistory
{
    private ProductHistoryRepositoryInterface $productHistoryRepositoryInterface;

    public function __construct(ProductHistoryRepositoryInterface $productHistoryRepositoryInterface)
    {
        $this->productHistoryRepositoryInterface = $productHistoryRepositoryInterface;
    }

    public function execute(
        ?string $people_name,
        ?string $people_phone,
        ?string $people_email,
        ?int $assignment_quantity,
        ?string $assign_date,
        ?string $devolution_date,
        string $observation,
        int $productId
    ) {
        $newHistory = new ProductHistoryEntity(
            id: null,
            people_name: $people_name,
            people_phone: $people_phone,
            people_email: $people_email,
            assignment_quantity: $assignment_quantity,
            assign_date: $assign_date,
            devolution_date: $devolution_date,
            observation: $observation,
        );
        $history = $this->productHistoryRepositoryInterface->store($newHistory, $productId);
        return ProductHistoryTransformer::toDTO($history);
    }
}
