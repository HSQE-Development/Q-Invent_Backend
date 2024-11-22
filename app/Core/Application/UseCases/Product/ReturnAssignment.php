<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Infrastructure\Transformers\ProductTransformer;

class ReturnAssignment
{
    protected ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(
        ProductRepositoryInterface $productRepositoryInterface
    ) {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    public function execute(int $productId, int $peopleId)
    {
        $product = $this->productRepositoryInterface->returnAssignment($productId, $peopleId);
        return ProductTransformer::toDTO($product);
    }
}
