<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Domain\Repositories\ProductRepositoryInterface;

class VerifyDisponibility
{
    protected ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(
        ProductRepositoryInterface $productRepositoryInterface
    ) {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    public function execute(int $productId, int $totalForAssignment)
    {
        return $this->productRepositoryInterface->verifyDisponibilityInInventory($productId, $totalForAssignment);
    }
}
