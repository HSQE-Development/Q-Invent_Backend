<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Infrastructure\Transformers\ProductTransformer;

class FindProductById
{
    protected ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    public function execute(int $id)
    {
        $product = $this->productRepositoryInterface->getById($id);
        return ProductTransformer::toDTO($product);
    }
}
