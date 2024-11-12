<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Domain\Repositories\ProductRepositoryInterface;

class DeleteProduct
{
    protected ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    public function execute(int $id): bool
    {
        $existingProduct = $this->productRepositoryInterface->getById($id);

        if (!$existingProduct) {
            throw new \Exception("Customer not found");
        }

        return $this->productRepositoryInterface->delete($id);
    }
}
