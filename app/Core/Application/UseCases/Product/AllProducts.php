<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Infrastructure\Transformers\ProductTransformer;

class AllProducts
{
    protected ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    public function execute()
    {
        $products = $this->productRepositoryInterface->all();
        return ProductTransformer::toDTOs($products);
    }
}
