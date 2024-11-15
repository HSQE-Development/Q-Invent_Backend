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
        int $total_quantity,
        string $quantity_type,
        string $ubication,
        string $observation,
        string $active = "A"
    ) {
        $customer = new ProductEntity(
            null,
            $name,
            $total_quantity,
            $quantity_type,
            $ubication,
            $observation,
            $active
        );
        $this->productRepositoryInterface->store($customer);
        return ProductTransformer::toDTO($customer);
    }
}
