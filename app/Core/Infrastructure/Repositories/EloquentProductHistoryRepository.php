<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Entities\ProductHistoryEntity;
use App\Core\Domain\Repositories\ProductHistoryRepositoryInterface;
use App\Models\ProductHistory;

class EloquentProductHistoryRepository implements ProductHistoryRepositoryInterface
{
    public function store(ProductHistoryEntity $product, int $productId): ProductHistoryEntity
    {
        $eloquentProduct = new ProductHistory();
        $eloquentProduct->id = $product->getId();
        $eloquentProduct->people_name = $product->getPeople_name();
        $eloquentProduct->people_phone = $product->getPeople_phone();
        $eloquentProduct->people_email = $product->getPeople_email();
        $eloquentProduct->assignment_quantity = $product->getAssignment_quantity();
        $eloquentProduct->assign_date = $product->getAssign_date();
        $eloquentProduct->devolution_date = $product->getDevolution_date();
        $eloquentProduct->observation = $product->getObservation();
        $eloquentProduct->product_id = $productId;
        $eloquentProduct->save();
        $product->setId($eloquentProduct->id);
        return $product;
    }
}
