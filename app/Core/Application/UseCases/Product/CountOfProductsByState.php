<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Domain\EnumProductStatus;
use App\Core\Domain\Repositories\ProductRepositoryInterface;

class CountOfProductsByState
{
    protected ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    public function execute(?string $status)
    {
        if ($status === "A") {
            return $this->productRepositoryInterface->countTotalActiveOfProducts();
        } else if ($status === "I") {
            return $this->productRepositoryInterface->countTotalInactiveOfProducts();
        } else {
            return $this->productRepositoryInterface->countTotalOfProducts();
        }
    }
}
