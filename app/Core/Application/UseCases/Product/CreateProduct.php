<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Domain\Entities\ProductEntity;
use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Infrastructure\Transformers\ProductTransformer;

class CreateProduct
{
    protected ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    public function execute(
        string $name,
        string $total_quantity,
        string $ubication,
        string $observation
    ) {
        $customer = new ProductEntity(
            null,
            $name,
            $total_quantity,
            $ubication,
            $observation

        );
        $this->productRepositoryInterface->store($customer);
        return ProductTransformer::toDTO($customer);
    }
}
