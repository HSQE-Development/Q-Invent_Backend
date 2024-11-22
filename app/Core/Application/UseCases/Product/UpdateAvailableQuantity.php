<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Infrastructure\Transformers\ProductTransformer;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class UpdateAvailableQuantity
{
    protected ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(
        ProductRepositoryInterface $productRepositoryInterface
    ) {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    public function execute(int $productId)
    {
        $product = $this->productRepositoryInterface->updateAvailableQuantityByTotalQuantity($productId);
        return ProductTransformer::toDTO($product);
    }
}
